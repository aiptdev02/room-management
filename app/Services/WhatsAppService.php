<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $token;
    protected $phoneNumberId;

    public function __construct()
    {
        // $this->token = config('services.whatsapp.token');
        // $this->phoneNumberId = config('services.whatsapp.phone_number_id');

        $this->token = "EAASFdQX2amcBPYok14lABGrgN3V2dZBB9D6odU2lMDKCgGd7umIft7tHRYfCZBjlTRgHzg7X94kEfienUn1qqxZBsdSUDYh6gP2FanOKZB1zvuN5TPoaLXUqGamZAOIZCduiQx6tvrzTzRZAkZBt8k74f2880it11aswJkbmv6UDQkOik3GkiSx3mcHGvWtzbtc1so0yOsT73V4i4chtpOSs8B2Urr86XnghrudSZBywpv7NA39vspI3vJsqmuGsZD";
        $this->phoneNumberId = "731005443437346";
    }

    public function sendMessage($to, $message)
    {
        $url = "https://graph.facebook.com/v20.0/{$this->phoneNumberId}/messages";

        $response = Http::withToken($this->token)->post($url, [
            "messaging_product" => "whatsapp",
            "to" => $to, // recipient phone number in international format
            "type" => "text",
            "text" => [
                "body" => $message
            ]
        ]);

        return $response->json();
    }
}
