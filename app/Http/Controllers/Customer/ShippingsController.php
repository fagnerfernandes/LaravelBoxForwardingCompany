<?php

namespace App\Http\Controllers\Customer;

use App\Enums\AffiliateBenefitTypesEnum;
use App\Enums\PurchaseStatusEnum;
use App\ExternalApi\Payments\Payment;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeclarationType;
use App\Models\PackageItem;
use App\Models\Shipping;
use App\Models\ShippingItem;
use App\Models\ShippingExtraService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\ExternalApi\Shipping\Skypostal;
use App\ExternalApi\Shipping\Usps\Rate;
use App\ExternalApi\Shipping\Usps\RatePackage;
use App\ExternalApi\Shipping\Usps\InternationalLabel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Box;
use App\Models\Fee;
use App\Models\Payment as ModelsPayment;
use Illuminate\Support\Facades\Auth;

class ShippingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Shipping::query()->with('shipping_form')->with('purchase');

        if (request()->has('keyword') && !empty(request()->get('keyword'))) {
            $keyword = request()->get('keyword');

            $query->where(function($q) use($keyword) {
                foreach (Shipping::fields() as $field) {
                    $q->orWhere($field, 'LIKE', "%{$keyword}%");
                }
            });
        }

        $rows = $query->latest()->paginate();

        return view('customer.shippings.index', compact('rows'));
    }

    private function replaceData($keyword)
    {
        $data = [
            'Pendente' => '0',
            'Preparando envio' => '1',
            'Entregue' => '2',
            'Cancelado' => '3',
        ];

        $strings = array_keys($data);
        $new_strings = array_values($data);

        if (in_array($keyword, $strings)) {
            return $data[$keyword];
        }
        return $keyword;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = PackageItem::whereSent(0)->get();
        $addresses = Address::orderBy('name')->pluck('name', 'id');
        return view('customer.shippings.create', compact('items', 'addresses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'items' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            $shipping = Shipping::create(['user_id' => auth()->user()->id]);

            foreach ($request->get('items') as $item) {
                $shipping->items()->create([
                    'package_item_id' => $item['package_item_id'],
                    'amount' => $item['amount'],
                    'weight' => $item['weight'],
                ]);
            }

            if ($request->has('extra_services') && !empty($request->get('extra_services'))) {
                foreach ($request->get('extra_services') as $service) {
                    $shipping->extra_services()->create(['extra_service_id' => $service]);
                }
            }
            DB::commit();
            flash()->success('Solicitação criada com sucesso! Escolha o frete e faça o pagamento.');
            return redirect()->route('customer.shippings.declaration', ['id' => $shipping->id]);

        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Houve um erro ao processar o envio', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            // dd($e->getMessage());
            flash()->error('Houve um erro ao processar a solicitação: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipping = Shipping::with('items', 'extra_services', 'shipping_form')->findOrFail($id);

        return view('customer.shippings.show', compact('shipping'));
    }

    /**
     * ExtraServices - Guarda em sessao os serviços extras escolhidos
     *
     */
    public function extraServicesPost(Request $request)
    {
        if (
            $request->has('extra_services') &&
            !empty($request->get('extra_services'))
        ) {
            // Filtra somente os serviços escolhidos pelo cliente
            $extra_services = collect($request->get('extra_services'))->filter(function($service) {
                if (isset($service['id'])) return $service;
            })->all();

            session()->put('extra_services', $extra_services);
        }

        return redirect()->to(route('customer.shippings.declaration'));
    }

    public function declaration()
    {
        $types = DeclarationType::orderBy('name')->pluck('name', 'id');

        return view('customer.shippings.declaration')->with(compact('types'));
    }

    public function declarationPost(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            $session_items = session()->get('items');
            $items = $request->get('items');

            $total_itens_price_declared = 0;

            foreach ($session_items as $key => $sItem) {
                $item = collect($items)->where('package_item_id', $sItem['package_item_id'])->first();
                $session_items[$key] += $item;

                $declaration_type = DeclarationType::find($item['declaration_type_id']);
                $session_items[$key]['declaration_type'] = $declaration_type->name;

                //$total_itens_price_declared = $total_itens_price_declared+$item['value'];
            }
            session()->put('items', $session_items);

            //flash()->success('Entrega atualizada com sucesso!');
            // return redirect()->route('customer.shippings.checkout', ['id' => $id]);
            return redirect()->route('customer.shippings.address');

        } catch (Exception $e) {
            DB::rollBack();
            $msg = 'Houve um erro ao atualizar a entrega e seus itens';
            logger()->error($msg, [$e->getMessage(), $e->getLine()]);
            // dd($e->getMessage(), $e->getLine());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function declarationDestroy($package_item_id)
    {
        $key = collect(session()->get('items'))->where('package_item_id', $package_item_id)->keys();
        $items = session()->get('items');
        unset($items[$key[0]]);

        flash()->success('Item removido com sucesso!');
        if (count($items) == 0) {
            return redirect()->to(route('customer.items.available'));
        } else session()->put('items', $items);
        return redirect()->back();
    }

    // Escolhe qual endereço que vai receber a mercadoria
    public function chooseAddress()
    {
        $addresses = Address::orderBy('name')->get();
        return view('customer.shippings.choose_address', compact('addresses'));
    }

    public function chooseAddressPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ], [
            'address_id.required' => 'Escolha um endereço para enviar o pacote',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        // Grava todos os dados do pedido de envio para gerar a cobrança
        $address = Address::find($request->get('address_id'));

        session()->put('address', $address->toArray());

        return redirect()->to(route('customer.shippings.method'));
    }

    public function chooseMethod()
    {
        if(!session()->get('items')){
            return redirect('/customer/shippings');
        }

        $packages = Shipping::$packages;
        $total_extra_services = collect(session()->get('extra_services'))->sum('price');

        $weight_items = 0;
        foreach (session()->get('items') as $key => $sItem) {
            $weight_items += $sItem['weight']*$sItem['quantity'];
        }

        //$weight_items = collect(session()->get('items'))->sum('weight');

        $weight_services = collect(session()->get('extra_services'))->sum('weight');
        $total_weight = $weight_items + $weight_services;

        session()->put('weight', [
            'items'     => $weight_items,
            'services'  => $weight_services,
            'total'     => $total_weight,
        ]);

         //dd(session()->get('items'), session()->get('extra_services'), $weight_items, $weight_services, $total_weight);

        return view('customer.shippings.choose_method', compact('packages', 'total_extra_services', 'weight_items', 'weight_services', 'total_weight'));
    }

    public function chooseMethodPost(Request $request)
    {

        $input      = $request->all();
        $package    = collect(Shipping::$packages)->where('name', $input['package_id'])->first();

        $input += [
            'package_price' => $package['price'],
            'package_weight' => $package['weight'],
        ];

        $total_weight = session()->get('weight.total');

        session()->put('weight', [
            'total' => ($total_weight+$package['weight'])
        ]);

        $companyFee = Fee::companyFee(floatval($total_weight+$package['weight']))->first();

        session()->put('shipping', $input);
        session()->put('shipping.company_fee', floatval($companyFee->value));
        
        //dd(session()->all());
        $insurance = session()->get('shipping.insurance', 0);
        $actualShippingPrice = session()->get('shipping.price', 0);

        if($insurance==1){
            $calcInsurance = session()->get('shipping.total_declarado', 0)/100*0.4;
        } else {
            $calcInsurance = 0;
        }
        session()->put('shipping.price', floatval($actualShippingPrice)+floatval($calcInsurance)/* +floatval($companyFee->value) */);
// echo '<pre>';
// var_dump(session()->get('shipping'));
// die();
        return redirect()->route('customer.shippings.checkout');
    }

    public function checkout()
    {
        // dd(session()->get('items'), session()->get('address'), session()->get('extra_services'), session()->get('shipping'), session());
        $freeShipping = Auth::user()->userable->affiliateCourtesyServices()->available()->ofType(AffiliateBenefitTypesEnum::FREE_SHIPPING)->first();

        return view('customer.shippings.checkout')->withFreeShipping($freeShipping);
    }

    public function checkoutPost(Request $request)
    {

        session()->put('declarations_values', [
            'declaration_price' => $request['declaration_total_price'],
            'declaration_amount' => $request['declaration_total_amount'],
        ]);


        //dd(session()->get('items'), session()->get('shipping'), session()->get('address'), session()->get('extra_services'));
        DB::beginTransaction();
        try {

            //checa a quantidade de items
            $totalItens = 0;
            foreach (session()->get('items') as $qtd) {
                $totalItens = $totalItens+$qtd['quantity'];
            }

            $freeShipping = Auth::user()->userable->affiliateCourtesyServices()->available()->ofType(AffiliateBenefitTypesEnum::FREE_SHIPPING)->first();
            if (isset($freeShipping->max_value) && (floatval(session()->get('shipping.price')) <= $freeShipping->max_value)) {
                $valueShipping = 0;
                $statusShipping = 1; //pago
                $usedCortesyFreeShipping = true;
            } else {
                $valueShipping = floatval(session()->get('shipping.price'));
                $statusShipping = 0; //pendente
                $usedCortesyFreeShipping = false;
            }

            //criamos o pacote de envio para o endereco do cliente
            $shipping = Shipping::create([
                'shipping_name' => session()->has('shipping_name') ? session()->get('shipping_name') : '',
                'amount' => $totalItens,
                'weight' => session()->get('weight.total'),
                //'declaration_type_id'     => session()->get('shipping.declaration_type_id'),
                'declaration_type_id'       => 1, //checar se tera tipos de declaracao diferente em um mesmo envio com varios pedidos
                'declaration'               => session()->get('shipping.declaration'),
                'value'                     => $valueShipping,
                'company_fee'                  => floatval(session()->get('shipping.company_fee', 0)),
                'postal_fee'                => floatval(session()->get('shipping.postal_fee', 0)),
                'address_id'                => session()->get('address.id'),
                'status'                    => $statusShipping,
                'insurance'                 => session()->get('shipping.insurance'),
                'declaration_price'         => session()->get('declarations_values.declaration_price'),
                'declaration_amount'        => session()->get('declarations_values.declaration_amount'),
                'shipping_form_id'          => session()->get('shipping.shipping_form_id'),
            ]);

            if ($usedCortesyFreeShipping) {
                $freeShipping->update([
                    'courtesable_type' => Shipping::class,
                    'courtesable_id' => $shipping->id,
                    'used' => true,
                    'used_at' => Carbon::now()
                ]);

                $shipping->purchase()->create([
                    'value' => 0,
                    'purchase_status_id' => PurchaseStatusEnum::PAYED
                ]);
            }

           //gravamos os items que esta sendo enviados neste pacote
            foreach (session()->get('items') as $item) {
                $shippingItem = ShippingItem::create([
                    'package_item_id'           => $item['package_item_id'],
                    'amount'                    => $item['quantity'],
                    'status'                    => 0, //pendente
                    'price'                     =>  session()->get('shipping.package_price'),
                    'shipping_form_id'          => session()->get('shipping.shipping_form_id'),
                    'address_id'                => session()->get('address.id'),
                    //'tracking_code',
                    'observation'               => $item['description'],
                    'shipping_package'          => session()->get('shipping.package_id'),
                    'shipping_package_price'    => session()->get('shipping.package_price'),
                    'shipping_package_weight'   => session()->get('shipping.package_weight'),
                    'company_tax'              => session()->get('shipping.company_tax'),
                    'declaration_type_id'       => $item['declaration_type_id'],
                    //'cambioreal_token',
                    //'cambioreal_code',
                    'shipping_id'               => $shipping->id,
                    'weight'                    => $item['weight'],
                    'declaration_amount'        => $item['declaration_amount'],
                    'declaration_price'         => $item['value'],
                    'declaration'               => $item['declaration'],
                ]);

                //atualizamos a quantidade de items disponiveis na suite
                $packageItem        = packageItem::find($item['package_item_id']);
                $totalItemsAtual    = $item['quantity']+$packageItem->amount_sent;

                $packageItem->update([
                    'amount_sent' => $totalItemsAtual,
                ]);

            }

            //gravamos os servicos extras
            foreach (session()->get('extra_services') as $service) {
                $shippingExtraService = ShippingExtraService::create([
                    'shipping_id' => $shipping->id,
                    'extra_service_id' => $service['id'],
                    'price' => $service['price'],
                    'weight' => $service['weight'],
                ]);
            }

            DB::commit();

            flash()->success('Solicitação de envio efetuada com sucesso!');
            return redirect()->route('customer.shippings.show', ['shipping' => $shipping]);

        } catch (Exception $e) {
            DB::rollBack();
            $msg = 'Houve um erro ao fazer a solicitação de envio: ';
            logger()->error($msg, [
                $e->getMessage(),
                $e->getLine(),
            ]);

            flash()->error($msg . $e->getMessage());
            return redirect()->back();
        }
    }

    public function thanks()
    {
        return view('customer.shippings.thanks');
    }

    public function usps2(){


        // Initiate and set the username provided from usps
        $label  = new InternationalLabel(env('USPS_USER_NAME'));

        // Express by default
        //$label->setApiVersion('ExpressMailIntl');

        // PriorityMailIntl
        //$label->setApiVersion('PriorityMailIntl');

        // FirstClassMailIntl
        $label->setApiVersion('FirstClassMailIntl');

        // During test mode this seems not to always work as expected
        //$label->setTestMode(true);

        $label->setFromAddress('John', 'Dow', '', '5161 Lankershim Blvd', 'North Hollywood', 'CA', '91601', '# 204');
        $label->setToAddress('Vincent', 'Gabriel', '5440 Tujunga Ave', 'North Hollywood', 'GO', 'BR', '74843100', '# 707');
        $label->setWeightOunces(1);

        $label->addContent('Shirt', '10', 0, 10);

        // Perform the request and return result
        $label->createLabel();

        //print_r($label->getArrayResponse());
        print_r($label->getPostData());
        //var_dump($label->isError());

        // See if it was successful
        if ($label->isSuccess()) {
            echo 'Done';
            echo "\n Confirmation:" . $label->getConfirmationNumber();

            $label = $label->getLabelContents();
            if ($label) {
                $contents = base64_decode($label);
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="label.pdf"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . strlen($contents));
                echo $contents;
                exit;
            }
        } else {
            echo 'Error: ' . $label->getErrorMessage();
        }
    }

    public function label(Request $request){

        try {
            if(is_numeric($request['id'])){
                $shipping_id    =  $request['id'];
                $shipping       = Shipping::with('items', 'extra_services', 'shipping_form')->findOrFail($shipping_id);
                $address        = Address::find($shipping['address_id']);
                $userShipping   = User::find($shipping['user_id']);
                $box            = Box::find($shipping['boxes_id']);

                $label                  = $this->labelSkypostal($shipping, $address, $userShipping, $box);

                $shippingUpdate         = Shipping::find($shipping_id);

                $shippingUpdate->update([
                    'label'             => $label[0]['label_url'],
                    'shipping_invoice'  => $label[0]['label_invoice_url'],
                    'tracking_code'     => $label[0]['label_tracking_number_01'],
                ]);

                // echo '<pre>';
                // var_dump($label);
                // die();

                return redirect(env('APP_URL').'/shippings/'.$shipping_id);

            } else {
                return false;
            }

        } catch (Exception $e) {
            $msg = 'Houve um erro ao fazer ao tentar gerar a etiqueta ';
            logger()->error($msg, [
                $e->getMessage(),
                $e->getLine(),
            ]);

            flash()->error($msg . $e->getMessage());
            return redirect()->back();
        }
    }

    public function labelSkypostal($shipping, $address, $userShipping, $box){
        $shipping['id'] = '712345'.$shipping['id'];
        $dateTime       = Carbon::today()->toDateString().'T13:15:00-06:00';

        // echo '<pre>';
        // var_dump($shipping['items']);
        // die();

        $insurance_value = 0;
        foreach ($shipping['items'] as $key => $items){

            $declarationType    = DeclarationType::where( 'id', '=', $items['declaration_type_id'] )->firstOrFail();
            $value_unit         = $items['declaration_price']/$items['declaration_amount'];

            if(isset($shipping['insurance'])&&$shipping['insurance']==1){
                $insurance_code     = 1; //0 = Follow insurance account rules. 1 = Apply insurance
                $insurance_value    = $insurance_value+(($items['declaration_price']/100)*0.4); //40 cents a cada 100 dolares
            } else {
                $insurance_code     = 2; //2 = Reject insurance
                $insurance_value    = 0;
            }

            $itemList[$key] = [
                'hs_code'               => $declarationType['hs_code_skypostal'],
                'family_product'        => $declarationType['family_product_skypostal'],
                'serial_number'         => null,
                'imei_number'           => null,
                'description'           => $items['declaration'],
                'product_brand'         => '',
                'product_name'          => '',
                'product_model'         => '',
                'quantity'              => $items['declaration_amount'],
                'tax'                   => null,
                'value'                 => $value_unit,
                'weight'                => $items['weight'],
            ];
        }

        $payload = [
            'user_info' => [
                'user_code' => env('SKYPOSTAL_USER_CODE'),
                'user_key'  => env('SKYPOSTAL_USER_KEY'),
                'app_key'   => env('SKYPOSTAL_APP_KEY'),
            ],

            'shipment_info' => [
                'copa_id' => 1459,
                'box_id'  => 981900,
                'merchant' => [
                    'name' => 'Company LLC',
                    'email'  => 'noreply@company.com',
                    'address' => [
                        'country_code'          => null,
                        'country_iso_code'      => null,
                        'country_name'          => null,
                        'state_code'            => null,
                        'state_name'            => 'FL',
                        'state_abbreviation'    => null,
                        'county_code'           => null,
                        'county_name'           => null,
                        'city_code'             => 0,
                        'city_name'             => 'CITY',
                        'zip_code'              => 'ZIP',
                        'town_code'             => null,
                        'town_name'             => null,
                        'neighborhood'          => null,
                        'address_01'            => 'ADDRESS',
                        'address_02'            => null,
                        'address_03'            => null,
                    ],
                    'return_address' => [
                        'country_code'          => null,
                        'country_iso_code'      => null,
                        'country_name'          => null,
                        'state_code'            => null,
                        'state_name'            => null,
                        'state_abbreviation'    => null,
                        'county_code'           => null,
                        'county_name'           => null,
                        'city_code'             => 0,
                        'city_name'             => null,
                        'zip_code'              => null,
                        'town_code'             => null,
                        'town_name'             => null,
                        'neighborhood'          => null,
                        'address_01'            => null,
                        'address_02'            => null,
                        'address_03'            => null,
                    ],
                    'phone' => [
                        'phone_type' => 2, //Can be 1 = fixed telephony and 2 = cell phone.
                        'phone_number'  => '8888888888',
                    ],
                ],

                'shipper' => null,
                'sender' => null,

                'consignee' => [
                    'first_name'        => $address['name'],
                    'last_name'         => '',
                    'email'             => $userShipping['email'],
                    'id_number'         => "34.028.316/0001-03", //CNPJ do correios Brasileiro, parceiro da Skypostal
                    'id_search_string'  => 'shipping_id: '.$shipping['id'], //qualquer coisa
                    'address' => [
                        'country_code'          => null,
                        'country_iso_code'      => 'BR',
                        'country_name'          => 'Brazil',
                        'state_code'            => 0,
                        'state_name'            => $address['state'],
                        'county_code'           => null,
                        'county_name'           => null,
                        'city_code'             => 0,
                        'city_name'             => $address['city'],
                        'zip_code'              => $address['postal_code'], //26130200,
                        'neighborhood'          => null,
                        'address_01'            => $address['street'],
                        'address_02'            => $address['number'] . ' - ' . $address['complement'],
                        'address_03'            => $address['district'],
                    ],
                    'phone' => [
                        'phone_type' => 2, //Can be 1 = fixed telephony and 2 = cell phone.
                        'phone_number'  => '3476981768',
                    ],
                ],

                'options' => [
                    'include_label_data'            => false,
                    'include_label_zpl'             => true,
                    'zpl_encode_base64'             => true,
                    'zpl_label_dpi'                 => 203,
                    'include_label_image'           => false,
                    'include_label_image_format'    => 'PNG',
                    'manifest_type'                 => 'DDU',
                    'insurance_code'                => $insurance_code,
                    'rate_service_code'             => $shipping['shipping_form_id'], //tipo do envio 301 ou 302
                    'generate_label_default'        => false,
                    'return_if_exists'              => false,

                    'additional_services' => [
                        'zipcode_validation'            => 1,
                        'id_validation'                 => 0,
                        'harmonization_code_validation' => 0,
                    ],

                ],

                'data' => [
                    'external_tracking'             => 'company-drop-'.$shipping['id'], //codigo unico criado por nos aqui
                    'reference_date'                => $dateTime,
                    'reference_number_01'           => null,
                    'reference_number_02'           => null,
                    'reference_number_03'           => null,
                    'tax'                           => null,
                    'value'                         => $items['declaration_price'],
                    'discount'                      => 0,
                    'freight'                       => $shipping['value'],//frete cobrado do cliente
                    'insurance'                     => $insurance_value,
                    'currency_iso_code'             => 'USD',
                    'dimension_01'                  => $box['depth'],
                    'dimension_02'                  => $box['height'],
                    'dimension_03'                  => $box['width'],
                    'dimension_unit'                => 'IN',
                    'weight'                        => $shipping['weight_mensured'] ? $shipping['weight_mensured'] : $shipping['weight'],
                    'weight_unit'                   => 'LB',

                    'items' =>
                        $itemList
                ],
            ],

        ];

        //  $a = json_encode($payload);

        // echo '<pre>';
        // var_dump($a);
        // die();

        file_put_contents("skypostal.json", json_encode($payload), FILE_APPEND);

        $url = env('SKYPOSTAL_URL') .'/wcf-services/service-shipment.svc/shipment/new-shipment';

        //ini_set('max_execution_time', 180); //3 minutes

        $res = Http::acceptJson()->post($url, $payload);

        if ($res->status()) {
            $data = $res->json()['data'];
            return $data;
            // echo '<pre>';
            // var_dump($data);
        } else {
            echo 'Error Skypostal: ';
            return false;
        }

    }

    public function fee(Request $request){

        try {

        $data = DB::table('fees')
        ->where([
            ['weight_min','<=',$request['total_weight_final']],
            ['weight_max','>=',$request['total_weight_final']],
        ])
        ->first();

            $percent        = $data->value; //example 3.00 = 3%
            //$total_value    = $request['total_value'];

            //$valueCompany = ($total_value*$percent)/100;

        // echo '<pre>';
        // var_dump($data->value);
        // die();
        return $percent;

        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('Houve um erro ao calcular a fee', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            // dd($e->getMessage());
            flash()->error('Houve um erro ao processar a solicitação: '. $e->getMessage());
            return redirect()->back()->withInput($request->all());

        }
    }

    public function finish(Request $request, $id, $gateway)
    {
        try {
            $shippingPurchase = Shipping::with('purchase.payments')->findOrFail($id);

            $transaction = (new Payment())->register($shippingPurchase, $gateway, $request->all());
            
            return redirect($transaction->bill_url);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
