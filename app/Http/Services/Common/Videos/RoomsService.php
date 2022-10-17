<?php 
 namespace App\Http\Services\Common\Videos;

use App\Http\Services\Common\Videos\TokensGenerating;
use Illuminate\Support\Facades\Http;

 class RoomsService {
    
    public function createMeetingRoom($pendingAppointment) {
        $managementToken = (new TokensGenerating)->generateToken(true, false);
        return Http::withHeaders([
            'Authorization' => 'Bearer '.$managementToken.'',
        ])->acceptJson()
        ->post(''.env("100MS_APP_URL").'/rooms', [
            "name"=> ''.$pendingAppointment->inmate->national_id.'_'.$pendingAppointment->national_id.'_meeting',
            "description"=> "Meeting between ". $pendingAppointment->inmate->national_id ." and " . $pendingAppointment->national_id. " ",
            "template_id"=> env("100MS_APP_TEMPLATE_ID"),
            "region"=> "in"
        ]);
    }
}

?>