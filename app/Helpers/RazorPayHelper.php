<?php
namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RazorPayHelper
{
    public static function process($payData)
    {
        $rzkey = env("RZ_KEY");
        $rzsec = env('RZ_SEC');
        $razor = base64_encode($rzkey . ':' . $rzsec);
        $time = Carbon::now()->addMinutes(20)->timestamp;

        $data = json_encode(
            array(
                "amount" => $payData['amount'] * 100,
                "currency" => "INR",
                "accept_partial" => false,
                "first_min_partial_amount" => 0,
                "expire_by" => $time,
                "reference_id" => $payData['reference_id'],
                "description" => "Payment for policy no #23456",
                "customer" => [
                    "name" => $payData['name'],
                    "contact" => $payData['contact'],
                    "email" => $payData['email']
                ],
                "notify" => [
                    "sms" => false,
                    "email" => false
                ],
                "reminder_enable" => false,
                "notes" => [
                    "type" => $payData['notes']
                ],
                "callback_url" => $payData['callback_url'],
                "callback_method" => "get"
            )
        );

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $razor . ''
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }

    public static function fetch_payment_links($payData)
    {
        $rzkey = env("RZ_KEY");
        $rzsec = env('RZ_SEC');
        $razor = base64_encode($rzkey . ':' . $rzsec);

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links/'. $payData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $razor . ''
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
