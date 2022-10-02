<?php

namespace App\Http\Controllers\Visitors;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\ValidateInputs;
use App\Jobs\Visitor\AppointmentReceived;
use App\Models\Appointment;
use App\Models\Inmate;
use App\Models\Prison;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VisitorsController extends Controller
{
    public function  getHomePage()
    {
        $allPrisons = Prison::get();
        $allTariffs = Tariff::get();
        return view('visitors.appointmentRequest', compact('allPrisons', 'allTariffs'));
    }

    public function requestAppointment(Request $request)
    {
        $phoneFormat = 2507;
        $phoneTotalDigits = 12;
        $data = $request->all();
        $checkInmateExistence = Inmate::where('national_id', $data['inmateNationalId'])->where('status', \App\Models\Inmate::ACTIVE);
        try {
            DB::beginTransaction();
            if (!$checkInmateExistence->exists()) {
                return back()->withInput()->with('error','There is no inmate with such national ID');
            }
            // Check if Inmate exists and has no appointment on the selected date
            $inmateToVisit = $checkInmateExistence->first();
            $inmateToVisitPrison = $inmateToVisit->prison_id;
            $inmateToVisitId = $inmateToVisit->id;
            $checkInmateAppointment = Appointment::where('inmate_id', $inmateToVisitId)
            ->where('date', $data['visitDate']);

            if ($checkInmateAppointment->exists()) {
                return back()->withInput()->with('error','The selected inmate has another visit on the selected date');
            }
                
            if (!(new ValidateInputs)->validatePhoneNumber($data['telephone'], $phoneFormat, $phoneTotalDigits)) {
                return back()->withInput()->with('error','The Telephone number must start with '. $phoneFormat .'... and consists of '.$phoneTotalDigits.' digits');
            }
            
            $newAppointment = [
                'id' => Str::uuid()->toString(),
                'names' => $data['names'],
                'telephone' => $data['telephone'],
                'national_id' => $data['nationalId'],
                'inmate_id' => $inmateToVisitId,
                'prison_id' => $inmateToVisitPrison, 
                'tariff_id' => $data['tariff'],
                'date' => $data['visitDate'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            Appointment::insert($newAppointment);
            DB::commit();
            // Send Confirmation SMS to The User
            dispatch(new AppointmentReceived($newAppointment, $inmateToVisit));
            return back()->with('success', 'appointment made successfully... you will get a confirmation SMS');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('error','an error occured....please try again');
        }
    }
}
