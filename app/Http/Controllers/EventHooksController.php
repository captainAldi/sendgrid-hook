<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use SendGrid\EventWebhook\EventWebhook;
use SendGrid\EventWebhook\EventWebhookHeader;

class EventHooksController extends Controller
{
    
    public function handle_hook(Request $request)
    {

        // Cek Header Signature
        $header_signature = $request->header(EventWebhookHeader::SIGNATURE);
        if(!$header_signature)
        {
            Log::error("Request Header tidak ada signature ");
            return;
        }
        
        // Cek Header Timestamp
        $header_timestamp = $request->header(EventWebhookHeader::TIMESTAMP);
        if(!$header_timestamp)
        {
            Log::error("Request Header tidak ada timestamp ");
            return;
        }

        // Cek signature
        $eventWebhook = new EventWebhook();
        $ecPublicKey = $eventWebhook->convertPublicKeyToECDSA(env('SENDGRID_WEBHOOK_PUBLIC_KEY'));
        $data_eventss = $request->getContent();

        $verifiedSignature = $eventWebhook->verifySignature(
                                    $ecPublicKey,
                                    $data_events,
                                    $header_signature,
                                    $header_timestamp
                                );

        if (!$verifiedSignature) {
            Log::error("Signature tidak valid !");
            return;
        }


        // Lanjut jika signature valid
        $array_events = json_decode($data_events, true);
        foreach ($array_events as $key => $value) {
            Log::info("foreach event");
            Log::info($value);
        }        
        
        Log::info($data_events);
        
    }

}
