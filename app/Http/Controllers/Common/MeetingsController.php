<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\Videos\TokensGenerating;
use Illuminate\Http\Request;
use App\Models\Meeting_Token;

class MeetingsController extends Controller
{
    public function getMeetingPage()
    {
        return view('meetings.visitors.index');
    }

    public function provideNationalId(Request $request)
    {
        if ($request->session()->has('meeting')) {
            $request->session()->forget('meeting');
        }
        if ($request->session()->has('user_type')) {
            $request->session()->forget('user_type');
        }
        
        $data = $request->all();
        if ($data['userType'] === 'VISITOR') {
            // joining as visitor
            $checkCode = Meeting_Token::where('visitor_code', $data['code']);
            if (!$checkCode->exists()) {
                return back()->withInput()->with('error','No scheduled meeting with such Code available');
            } else {
                $meetingToken = $checkCode->first();
                $meeting = $meetingToken->meeting;
                $room = $meeting->room_id;
                $visitorToken =  (new TokensGenerating)->generateToken(false, false, $room);
                $meetingToken->update([
                    'visitor_token' => $visitorToken
                ]);
                $request->session()->put('meeting', $meeting);
                $request->session()->put('user_type', $data['userType']);
                return redirect()->route('joinMeeting');

            }
        } else {
            // joining as inmate
            $checkCode = Meeting_Token::where('inmate_code', $data['code']);
            if (!$checkCode->exists()) {
                return back()->withInput()->with('error','No scheduled meeting with such Code available');
            } else {
                $meetingToken = $checkCode->first();
                $meeting = $meetingToken->meeting;
                $room = $meeting->room_id;
                $inmateToken =  (new TokensGenerating)->generateToken(false, false, $room);
                $meetingToken->update([
                    'inmate_token' => $inmateToken
                ]);
                $request->session()->put('meeting', $meeting);
                $request->session()->put('user_type', $data['userType']);
                return redirect()->route('joinMeeting');

            }
        }
    }

    public function joinMeeting(Request $request)
    {
        if (!$request->session()->has('meeting')) {
            return redirect()->route('provideNationalId')->with('error','please provide your Code');
        }
        $meetingInfo = $request->session()->get('meeting');
        $userType = $request->session()->get('user_type');
        $appointment = $meetingInfo->appointment;
        $tariff = $appointment->tariff;
        return view('meetings.visitors.join', compact('meetingInfo','userType','appointment', 'tariff'));
    }
}
