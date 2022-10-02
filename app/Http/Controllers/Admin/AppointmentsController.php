<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\AppointmentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;

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
            // Send SMS To User Notifying And Payment
            DB::commit();
            dispatch(new AppointmentStatus($pendingAppointment, $pendingAppointment->inmate, true));

            //TODO Payments
            //---///
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
            dispatch(new AppointmentStatus($pendingAppointment, $pendingAppointment->inmate, false));
            return redirect()->route('getPendingAppointments')->with('success', 'appointment rejected successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'an error occured...please try again');
        }
    }
}
