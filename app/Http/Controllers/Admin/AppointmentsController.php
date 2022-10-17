<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\AppointmentStatus;
use App\Jobs\Videos\CreateRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Inmate;
use App\Http\Services\Common\ValidateInputs;
use App\Jobs\Admin\OutgoingAppointment;
use stdClass;

class AppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    //PENDING APPOINTMENTS

    public function getPendingAppointments()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $pendingAppointments = $currentPrison->appointments()->where('status', Appointment::PENDING)->get();
        return view('admin.appointments.pending.index', compact('currentPrison','pendingAppointments','authenticatedUser'));
    }

    public function getSinglePendingAppointment($id)
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $pendingAppointment = Appointment::with('inmate')->with('tariff')->find($id);
        return view('admin.appointments.pending.show', compact('currentPrison','pendingAppointment','authenticatedUser'));
    }

    public function approveSinglePendingAppointment(Request $request, $id)
    {
        $pendingAppointment = Appointment::with('inmate')->with('tariff')->find($id);   
        try {
            DB::beginTransaction();
            $pendingAppointment->update([
                'status' => Appointment::APPROVED
            ]);
            DB::commit();
            // Create 100MS room and notify user about approval
            dispatch(new CreateRoom($pendingAppointment, $pendingAppointment->inmate, true));
            return redirect()->route('getPendingAppointments')->with('success', 'appointment approved successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'an error occured...please try again');
        }
    }

    public function rejectSinglePendingAppointment($id)
    {
        $pendingAppointment = Appointment::with('inmate')->with('tariff')->find($id);   
        try {
            DB::beginTransaction();
            $pendingAppointment->update([
                'status' => Appointment::REJECTED
            ]);
            // Send SMS To User Notifying
            DB::commit();
            dispatch(new AppointmentStatus($pendingAppointment, $pendingAppointment->inmate, false, null));
            return redirect()->route('getPendingAppointments')->with('success', 'appointment rejected successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'an error occured...please try again');
        }
    }

    //APPROVED APPOINTMENTS

    public function getApprovedAppointments()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $approvedAppointments = $currentPrison->appointments()->where('status', Appointment::APPROVED)->get();
        return view('admin.appointments.approved.index', compact('currentPrison','approvedAppointments','authenticatedUser'));
    }

    // REJECTED APPOINTMENTS

    public function getRejectedAppointments()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $rejectedAppointments = $currentPrison->appointments()->where('status', Appointment::REJECTED)->get();
        return view('admin.appointments.rejected.index', compact('currentPrison','rejectedAppointments','authenticatedUser'));
    }

    // INMATE REQUESTING APPOINTMENT
    public function createOutgoingAppointment()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        return view('admin.appointments.outgoing.create', compact('currentPrison','authenticatedUser'));
    }

    public function sendOutgoingAppointmentRequest(Request $request)
    {
        $phoneFormat = 2507;
        $phoneTotalDigits = 12;
        $data =  $request->all();
        if (!(new ValidateInputs)->validatePhoneNumber($data['telephone'], $phoneFormat, $phoneTotalDigits)) {
            return back()->withInput()->with('error','The Telephone number must start with '. $phoneFormat .'... and consists of '.$phoneTotalDigits.' digits');
        }

        try {
            DB::beginTransaction();
            $inmate = Inmate::where('inmate_code', $data['code']);
            if (!$inmate->exists()) {
                return back()->withInput()->with('error','Inmate with such code does not exist');   
            } else {
                $inmate = $inmate->first();
                $visitor = new stdClass();
                $visitor->names = $data['names'];
                $visitor->telephone = $data['telephone'];
                DB::commit();
                dispatch(new OutgoingAppointment($inmate, $visitor));
                return back()->with('success','request has been sent successfully');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'an error occured...please try again');
        }
    }

}
