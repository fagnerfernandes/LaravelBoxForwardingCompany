<?php

namespace App\Http\Controllers\Customer;

use App\ExternalApi\Shipping\Skypostal;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\MeRequest;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\ExternalApi\Shipping\Usps\Rate;
use App\ExternalApi\Shipping\Usps\RatePackage;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
{
    public function me()
    {
        $customer = Customer::with('user')->find(Auth::user()->userable_id);
        return view('customers.me', compact('customer'));
    }

    public function update(MeRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::whereEmail($request->get('user')['email'])->first();
            $userData = $request->get('user');
            
            if($request->has('user.avatar')) {
                $userData['avatar'] = $request->file('user.avatar')->store('avatars');
            }
            
            $user->update($userData);
            $user->userable()->update($request->only('document'));

            DB::commit();

            $user->fresh();

            Auth::login($user);

            flash()->success('Dados editados com sucesso!');
            return redirect(route('dashboard'));
        } catch (Exception $e) {
            DB::rollBack();
            flash()->error('Houve um erro ao editar os dados');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function changePassword()
    {
        return view('customers.change_password');
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->update( [ 'password' => $request->get('password') ] )) {
            flash()->success('Senha alterada com sucesso!');
        } else {
            flash()->error('Houve um erro ao alterar a senha');
        }
        return redirect()->back();
    }

    public function usps( Request $request){
//zip e country
        if(isset(
            $request->total_weight_final)
            && $request->total_weight_final!=null
            && $request->total_weight_final!=0
            && isset($request->total_value)
            && $request->total_value!=null
            && $request->total_value!=0
            && isset($request->postal_code)
            && $request->postal_code!=null
            && $request->postal_code!=0
            && isset($request->country)
            && $request->country!=null
            && $request->country!=0
            ){
                $dateTime = Carbon::today()->toDateString().'T13:15:00-06:00';

                $rate = new Rate(env('USPS_USER_NAME'));
                $rate->setInternationalCall(true);
                $rate->addExtraOption('Revision', 2);

                $package = new RatePackage(env('USPS_USER_NAME'));
                $package->setPounds($request->total_weight_final);
                $package->setOunces(0);
                $package->setField('Machinable', 'True');
                $package->setField('MailType', 'Package');
                $package->setField('GXG', array(
                'POBoxFlag' => 'Y',
                'GiftFlag' => 'Y'
                ));
                $package->setField('ValueOfContents', $request->total_value);
                $package->setField('Country', $request->country);
                $package->setField('Container', 'RECTANGULAR');
                $package->setField('Size', 'LARGE');
                $package->setField('Width', 10);
                $package->setField('Length', 10);
                $package->setField('Height', 10);
                $package->setField('Girth', 0);
                $package->setField('OriginZip', 33186);
                $package->setField('CommercialFlag', 'N');
                $package->setField('AcceptanceDateTime', $dateTime);
                $package->setField('DestinationPostalCode', $request->postal_code);

                // add the package to the rate stack
                $rate->addPackage($package);
                // Perform the request and print out the result
                // print_r($rate->getRate());
                // print_r($rate->getArrayResponse());
                $rate->getRate();
                $result = $rate->getArrayResponse();

                $data = $result['IntlRateV2Response']['Package']['Service'];


                //print_r($result['IntlRateV2Response']['Package']['Service']);
                // Was the call successful
                if ($rate->isSuccess()) {
                    return view('customer.shippings.usps_ajax', compact('data'));
                    echo 'Done';
                } else {
                    echo 'Error: ' . $rate->getErrorMessage();
                }
        } else {
            return false;
        }

        //return view('customer.shippings.thanks');
    }

    public function skypostal( Request $request ){

        /* $skyPostal = new Skypostal($request->total_weight_final, 0);
        $quote301 = $skyPostal->requestQuote();

        if ($quote301) {
            $data[] = [
                'name_type' => 'Packet Standard',
                'type' => 'Packet Standard',
                'value' => $quote301->data[0]->total_value
            ];
        }
        $skyPostal->serviceCode = 302; 
        $quote302 = $skyPostal->requestQuote();
        if ($quote302) {
            $data[] = [
                'name_type' => 'Packet Express',
                'type' => 'Packet Express',
                'value' => $quote302->data[0]->total_value
            ];
        } */

        $type1 = $this->skypostalRate($request, 301);
        $type2 = $this->skypostalRate($request, 302);

        if($type1!=false&&$type2==false){
            $type1[0]['name_type'] = 'Packet Standard';
            $data = $type1;
        } elseif($type1==false&&$type2!=false){
            $type1[0]['name_type'] = 'Packet Standard';
            $data = $type1;
        } elseif($type1!=false&&$type2!=false){
            $type1[0]['name_type'] = 'Packet Standard';
            $type2[0]['name_type'] = 'Packet Express';
            $data = array_merge($type1 ,$type2);
        } else {
            $data = null;
        }

        return view('customer.shippings.skypostal_ajax', compact('data'));
    }

    public function skypostalRateNew() {
        $skyPostal = new Skypostal($this->weight, 0, 'LB');
        $quote301 = $skyPostal->requestQuote();

        //$this->quotes[] = $quote301;
        if ($quote301) {
            $this->quotes[] = [
                'type' => 'Packet Standard',
                'value' => $quote301->data[0]->total_value
            ];
        }
        $skyPostal->serviceCode = 302; 
        $quote302 = $skyPostal->requestQuote();
        if ($quote302) {
            $this->quotes[] = [
                'type' => 'Packet Express',
                'value' => $quote302->data[0]->total_value
            ];
        }
    }

    //calcula valor do frete
    public function skypostalRate( Request $request, $skypostalType ){
        if(isset(
            $request->total_weight_final)
            && $request->total_weight_final!=null
            && $request->total_weight_final!=0
            && isset($request->total_value)
            && $request->total_value!=null
            && $request->total_value!=0
            && isset($request->postal_code)
            && $request->postal_code!=null
            && $request->postal_code!=0
            && isset($request->country)
            && $request->country!=null
            && $request->country!=0
            ){

                $ini_zip_code = $request->postal_code;
                $returnInfoSkypostal = $this->returnInfoSkypostal($request->postal_code);

                if(isset($returnInfoSkypostal[0])&&$returnInfoSkypostal[0]!=null&&$returnInfoSkypostal[0]!=''){

                    $payload = [
                        'user_info' => [
                            'user_code' => env('SKYPOSTAL_USER_CODE'),
                            'user_key'  => env('SKYPOSTAL_USER_KEY'),
                            'app_key'   => env('SKYPOSTAL_APP_KEY'),
                        ],
                        'weight'                => $request->total_weight_final,
                        'weight_type'           => 'lb',
                        'merchandise_value'     => $request->total_value,
                        'copa_id'               => 1459,
                        'country_code'          => 30, // 30 = Brazil
                        'city_code'             => $returnInfoSkypostal[0]->CITY_CODE,
                        'fmpr_cdg'              => 'VYC',
                        'height_dim'            => 26,
                        'length_dim'            => 26,
                        'width_dim'             => 26,
                        'dim_type'              => 'in',
                        'coupon_code'           => '',
                        'iata_code_origin'      => 'MIA',
                        'zip_code'              => $ini_zip_code,
                        'rate_service_code'     => $skypostalType,
                        'zone'                  => '',
                        'import_service_code'   => "DDP",
                        'iata_code_destination' => '',//
                        'apply_discount'        => 1,
                    ];

                    //file_put_contents("skypostal.json", json_encode($payload), FILE_APPEND);

                    $url = env('SKYPOSTAL_URL') .'/wcf-services/service-shipment.svc/shipment/get-shipment-rate';

                    $res = Http::acceptJson()->post($url, $payload);

                    if ($res->status()) {
                        $data = $res->json()['data'];

                        $postalFee = Setting::where('key', 'adicional.frete')->first();
                        if ($postalFee) {
                            $postalFeeValue = floatval($data[0]['total_value']) * (floatval($postalFee->value) / 100);
                            $data[0]['total_value'] = floatval($data[0]['total_value']) + $postalFeeValue;
                        }

                        $data[0]['postal_fee'] = $postalFeeValue ?? 0;

                        return $data;
                    } else {
                        //echo 'Error Skypostal: ';
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
    }

    public function returnInfoSkypostal( $zipcode ){
        $zip = str_replace("-", "", $zipcode );
        $zip2 = str_replace(".", "", $zip );

        if(is_numeric($zip2)){
            $zip_ini = substr($zip2, 0, 5);
            $zip_end = substr($zip2, 5, 3);
            $final_zip = $zip_ini . '-' . $zip_end;

            $data = DB::table('BRcitieszipcodes_csv')
                ->where('ZIPCODE', '=', $final_zip )
                ->get();

            return $data;
        } else {
            return false;
        }

    }

}
