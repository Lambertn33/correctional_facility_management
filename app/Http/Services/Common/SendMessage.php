<?php
 namespace App\Http\Services\Common;
 use Illuminate\Support\Facades\Http;

 class SendMessage {

    public function sendMessage($telephone, $message) {
        return Http::withHeaders([
            'Authorization' => 'Bearer '.env("SMS_TOKEN").'',
        ])->acceptJson()
        ->post(''.env("SMS_URL").'', [
           'sender' => 'CORRECTIONAL_FACILITY',
            'to' => '+'.$telephone,
            'text' => $message
        ]);
    }
}

?>
