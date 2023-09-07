<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use SendGrid\EventWebhook\EventWebhook;
use SendGrid\EventWebhook\EventWebhookHeader;

use App\Mail\TesKirimEmail;
use App\Models\DeliveryEvent;

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
        $data_events = $request->getContent();

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
            Log::info("Proses Simpan Data: " . $value['sg_message_id']);

            // Proses Simpan ke DB
            DB::beginTransaction();

            try {

                // Prepare Data
                $data_to_save       = new DeliveryEvent();
                $data_to_save->sender_identity = $value['identitas_pengguna'] ?? null;
                $data_to_save->email_to = $value['email'];
                $data_to_save->event = $value['event'];
                $data_to_save->timestamp = $value['timestamp'];

                $data_to_save->reason = $value['reason'] ?? null;
                $data_to_save->response = $value['response'] ?? null;
                $data_to_save->attempt = $value['attempt'] ?? null;
                $data_to_save->type = $value['type'] ?? null;

                // Keep Data
                $data_to_save->save();
                
                // Jika Semua Normal, Commit ke DB
                DB::commit(); 

                Log::info("Berhasil Simpan Data: " . $value['sg_message_id']);

            } catch (\Exception $e) {

                // Jika ada yang Gagal, Rollback DB
                DB::rollBack();

                Log::error('ERROR - Event Delivery - Save ', (array)$e->getMessage());

            }


        }        
        
    }

    public function test_kirim_email()
    {
        Mail::to(env("SEND_EMAIL_TO"))->send(new TesKirimEmail());
    }

}
