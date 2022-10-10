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
        return view('visitors.index');
    }
    
    public function getAppointmentsPage()
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
        if (!(new ValidateInputs)->validatePhoneNumber($data['telephone'], $phoneFormat, $phoneTotalDigits)) {
            return back()->withInput()->with('error','The Telephone number must start with '. $phoneFormat .'... and consists of '.$phoneTotalDigits.' digits');
        }
        try {
            DB::beginTransaction();
            $query = Inmate::where('prison_id', $data['prison'])
            ->where('names', 'LIKE', '%' .$data['inmate_names']. '%')
            ->where('status', \App\Models\Inmate::ACTIVE);
            
            if ($data['father_names'] && $data['mother_names'] && $data['inmateNationalId']) {
                $query = $query
                ->where('father_names', 'LIKE', '%' .$data['father_names']. '%')
                ->where('mother_names', 'LIKE', '%' .$data['mother_names']. '%')
                ->where('national_id', 'LIKE', '%' .$data['inmateNationalId']. '%');
            }
            if ($data['father_names'] && $data['mother_names'] && !$data['inmateNationalId']) {
                $query = $query
                ->where('father_names', 'LIKE', '%' .$data['father_names']. '%')
                ->where('mother_names', 'LIKE', '%' .$data['mother_names']. '%');
            }
            if ($data['father_names'] && !$data['mother_names'] && $data['inmateNationalId']) {
                $query = $query
                ->where('father_names', 'LIKE', '%' .$data['father_names']. '%')
                ->where('national_id', 'LIKE', '%' .$data['inmateNationalId']. '%');
            }
            if (!$data['father_names'] && $data['mother_names'] && $data['inmateNationalId']) {
                $query = $query
                ->where('mother_names', 'LIKE', '%' .$data['mother_names']. '%')
                ->where('national_id', 'LIKE', '%' .$data['inmateNationalId']. '%');
            }
            if (!$data['father_names'] && !$data['mother_names'] && $data['inmateNationalId']) {
                $query = $query
                ->where('national_id', 'LIKE', '%' .$data['inmateNationalId']. '%');
            }
            if (!$data['father_names'] && $data['mother_names'] && !$data['inmateNationalId']) {
                $query = $query
                ->where('mother_names', 'LIKE', '%' .$data['mother_names']. '%');
            }
            if ($data['father_names'] && !$data['mother_names'] && !$data['inmateNationalId']) {
                $query = $query
                ->where('father_names', 'LIKE', '%' .$data['father_names']. '%');
            }
            if (!$data['father_names'] && !$data['mother_names'] && !$data['inmateNationalId']) {
                $query = $query;
            }
            if (count($query->get()) == 0) {
                return back()->withInput()->with('error','there is no inmate with such information you provided');
            }
            $inmateToVisit = $query->first();
            $inmateToVisitPrison = $inmateToVisit->prison_id;
            $inmateToVisitId = $inmateToVisit->id;

            // Check if Inmate exists and has no appointment on the selected date
            $checkInmateAppointment = Appointment::where('inmate_id', $inmateToVisitId)
            ->where('date', $data['visitDate']);

            if ($checkInmateAppointment->exists()) {
                return back()->withInput()->with('error','The selected inmate has another visit on the selected date');
            }
                
            if (!(new ValidateInputs)->validatePhoneNumber($data['telephone'], $phoneFormat, $phoneTotalDigits)) {
                return back()->withInput()->with('error','The Telephone number must start with '. $phoneFormat .'... and consists of '.$phoneTotalDigits.' digits');
            }
            if (!(new ValidateInputs)->validateNationalIDLength($data['nationalId'])) {
                return back()->withInput()->with('error','The national ID Must consists of 16 digits');
            }
            if ($data['inmateNationalId']) {
                if (!(new ValidateInputs)->validateNationalIDLength($data['inmateNationalId'])) {
                    return back()->withInput()->with('error','The national ID Must consists of 16 digits');
                }
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
            throw $th;
            DB::rollback();
            return back()->withInput()->with('error','an error occured....please try again');
        }
    }
}
