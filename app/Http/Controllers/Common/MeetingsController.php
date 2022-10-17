<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\ValidateInputs;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Inmate;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;

class MeetingsController extends Controller
{
    public function getMeetingPage()
    {
        return view('meetings.visitors.index');
    }

    public function provideNationalId(Request $request)
    {
        if ($request->session()->has('meeting_info')) {
            $request->session()->forget('meeting_info');
        }
        $data = $request->all();
        if (!(new ValidateInputs)->validateNationalIDLength($data['nationalId'])) {
            return back()->withInput()->with('error','The national ID Must consists of 16 digits');
        }
        if ($data['userType'] === 'INMATE') {
             $inmate = Inmate::where('national_id', $data['nationalId']);
             if (!$inmate->exists()) {
                return back()->withInput()->with('error','No Inmate with such national ID available');
             } else {
                $inmate = $inmate->first();
                $appointment = Appointment::where('inmate_id', $inmate->id);
                if (!$appointment->exists()) {
                    return back()->withInput()->with('error','you currently have no appointments');
                } else {
                    $appointment = $appointment->first();
                    $meeting = Meeting::where('appointment_id', $appointment->id);
                    if (!$meeting) {
                        return back()->withInput()->with('error','you currently have no meeting to join');
                    } else {
                        $meeting =  $meeting->first();
                        $request->session()->put('meeting_info', $meeting);
                        $request->session()->put('user_type', $data['userType']);
                        return redirect()->route('joinMeeting');
                    }
                }
             }
        } else {
            $nationalId = Appointment::with('meeting')->where('national_id', $data['nationalId']);
            if (!$nationalId->exists()) {
                return back()->withInput()->with('error','No scheduled meeting with such national ID available');
            }
        }
        //TODO validations for meeting time, payments, ..... with be here

        $appointment = $nationalId->first();
        $meeting = $appointment->meeting;
        $request->session()->put('meeting_info', $meeting);
        $request->session()->put('user_type', $data['userType']);
        return redirect()->route('joinMeeting');
    }

    public function joinMeeting(Request $request)
    {
        // if (!$request->session()->has('meeting_info')) {
        //     return redirect()->route('provideNationalId')->with('error','please provide your National ID');
        // }
        $meetingInfo = $request->session()->get('meeting_info');
        $userType = $request->session()->get('user_type');
        $meetingInfo = Meeting::find($meetingInfo->id);
        return view('meetings.visitors.join', compact('meetingInfo','userType'));
    }
}
