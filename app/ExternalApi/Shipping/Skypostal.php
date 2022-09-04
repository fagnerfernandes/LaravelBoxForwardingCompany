<?php

namespace App\ExternalApi\Shipping;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// PROD https://api.skypostal.com
// TEST https://api-test.skypostal.com

class Skypostal
{
    protected $totalWeight = 0;
    protected $totalValue = 0;
    protected $weightType = '';

    public $serviceCode = 0;

    public function __construct($totalWeight, $totalValue, $weightType = 'LB', $serviceCode = 301)
    {
        $this->totalWeight = $totalWeight;
        $this->totalValue = $totalValue;
        $this->serviceCode = $serviceCode;
        $this->weightType = $weightType;

        $this->http = new Http();
        Http::macro('skypostal', function() {
            return Http::acceptJson()->baseUrl(env('SKYPOSTAL_URL'));
        });
    }

    protected function getJsonPayload() {
        return [
            'user_info' => [
                'user_code' => env('SKYPOSTAL_USER_CODE'),
                'user_key'  => env('SKYPOSTAL_USER_KEY'),
                'app_key'   => env('SKYPOSTAL_APP_KEY'),
            ],
            'weight'                => $this->totalWeight,
            'weight_type'           => $this->weightType,
            'merchandise_value'     => $this->totalValue,
            'copa_id'               => 1459,
            'country_code'          => 30, // 30 = Brazil
            'city_code'             => 2946,
            'fmpr_cdg'              => 'VYC',
            'height_dim'            => 10,
            'length_dim'            => 10,
            'width_dim'             => 10,
            'dim_type'              => 'in',
            'coupon_code'           => '',
            'iata_code_origin'      => 'MIA',
            'zip_code'              => '',
            'rate_service_code'     => $this->serviceCode,
            'zone'                  => '',
            'import_service_code'   => 'DDP',
            'iata_code_destination' => '',//
            'apply_discount'        => 0,
        ];
    }

    public function requestQuote() {
        $endpoint = '/wcf-services/service-shipment.svc/shipment/get-shipment-rate';

        try {
            Log::debug($this->getJsonPayload());
            $response = Http::skypostal()->post(
                $endpoint,
                $this->getJsonPayload()
            );
    
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            return false;
        }
    }

    // public function calculate()
    // {
    //     if(isset(
    //         $request->total_weight_final)
    //         && $request->total_weight_final!=null
    //         && $request->total_weight_final!=0
    //         && isset($request->total_value)
    //         && $request->total_value!=null
    //         &&$request->total_value!=0
    //         && isset($request->postal_code)
    //         && $request->postal_code!=null
    //         &&$request->postal_code!=0
    //         && isset($request->country)
    //         && $request->country!=null
    //         &&$request->country!=0
    //         ){

    //             $ini_zip_code = substr($request->postal_code, 0, 5);

    //             $payload = [
    //                 'user_info' => [
    //                     'user_code' => env('SKYPOSTAL_USER_CODE'),
    //                     'user_key'  => env('SKYPOSTAL_USER_KEY'),
    //                     'app_key'   => env('SKYPOSTAL_APP_KEY'),
    //                 ],
    //                 'weight'                => $request->total_weight_final,
    //                 'weight_type'           => 'lb',
    //                 'merchandise_value'     => $request->total_value,
    //                 'copa_id'               => 1459,
    //                 'country_code'          => 30, // 30 = Brazil
    //                 'city_code'             => 2946,
    //                 'fmpr_cdg'              => 'VYC',
    //                 'height_dim'            => 10,
    //                 'length_dim'            => 10,
    //                 'width_dim'             => 10,
    //                 'dim_type'              => 'in',
    //                 'coupon_code'           => '',
    //                 'iata_code_origin'      => 'MIA',
    //                 'zip_code'              => $ini_zip_code,
    //                 'rate_service_code'     => 301,
    //                 'zone'                  => '',
    //                 'import_service_code'   => '',
    //                 'iata_code_destination' => '',//
    //                 'apply_discount'        => 0,
    //             ];

    //             file_put_contents("skypostal.json", json_encode($payload), FILE_APPEND);

    //             $url = env('SKYPOSTAL_URL') .'/wcf-services/service-shipment.svc/shipment/get-shipment-rate';

    //             $res = Http::acceptJson()->post($url, $payload);

    //             dd($res->json(), $res->status());
    //             dd(get_object_vars($this));
    //         } else {
    //             return false;
    //         }
    // }

}
