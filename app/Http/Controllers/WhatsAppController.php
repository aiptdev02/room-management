<?php

namespace App\Http\Controllers;

use App\Models\PayingGuest;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function sendRentReminder($guestId)
    {
        $guest = PayingGuest::findOrFail($guestId);

        $message = "Hello {$guest->name},\n\nThis is a reminder to pay your rent for this month.\n\nThank you!";

        $response = $this->whatsapp->sendMessage($guest->phone, $message);

        return back()->with('success', 'WhatsApp message sent successfully!');
    }
}
