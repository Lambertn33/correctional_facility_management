<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\Videos\TokensGenerating;
use Illuminate\Http\Request;
use App\Models\Meeting_Token;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class MeetingsController extends Controller
{
    public function getMeetingPage(Request $request)
    {
        if ($request->session()->has('meeting')) {
            $request->session()->forget('meeting');
        }
        if ($request->session()->has('user_type')) {
            $request->session()->forget('user_type');
        }
        return view('meetings.visitors.index');
    }

    public function provideNationalId(Request $request)
    {
        if ($request->session()->has('meeting')) {
            $request->session()->forget('meeting');
        }
        if ($request->session()->has('meetingStartTime')) {
            $request->session()->forget('meetingStartTime');
        }
        if ($request->session()->has('meetingEndTime')) {
            $request->session()->forget('meetingEndTime');
        }
        if ($request->session()->has('user_type')) {
            $request->session()->forget('user_type');
        }
        
        $data = $request->all();
        if ($data['userType'] === 'VISITOR') {
            // joining as visitor
            //TODO Refactor Codes
            $checkCode = Meeting_Token::where('visitor_code', $data['code']);
            if (!$checkCode->exists()) {
                return back()->withInput()->with('error','No scheduled meeting with such Code available');
            } else {
                $meetingToken = $checkCode->first();
                $meeting = $meetingToken->meeting;
                if ($meeting->meeting_ended) {
                    return back()->withInput()->with('error', 'this meeting has been ended');
                }
                $now = now()->format('Y-m-d H:i:s');
                $meetingStart = $meeting->appointment->from;
                $meetingEnd = $meeting->appointment->to;
                $meetingStartTime =  strtotime($meetingStart);
                $meetingEndTime =  strtotime($meetingEnd);
                if ((strtotime($meetingStart) - strtotime($now)) > 0) {
                    $meetingDifferenceFromNowInMinutes =  ceil(round(abs(strtotime($meetingStart) - strtotime($now)) /60, 2));
                    if ($meetingDifferenceFromNowInMinutes > 2) {
                        return back()->withInput()->with('error', 'the meeting is allowed to be joined at least 2 minutes before');   
                    }
                } 
                $room = $meeting->room_id;
                $visitorToken =  (new TokensGenerating)->generateToken(false, false, $room, false);
                $meetingToken->update([
                    'visitor_token' => $visitorToken
                ]);
                $request->session()->put('meeting', $meeting);
                $request->session()->put('meetingStartTime', $meetingStartTime);
                $request->session()->put('meetingEndTime', $meetingEndTime);
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
                if ($meeting->meeting_ended) {
                    return back()->withInput()->with('error', 'this meeting has been ended on '.$meeting->appointment->date.' at ' .date('h:i:s', strtotime($meeting->appointment->from)) . ' ');
                }
                $now = now()->format('Y-m-d H:i:s');
                $meetingStart = $meeting->appointment->from;
                $meetingEnd = $meeting->appointment->to;
                $meetingStartTime =  date('H:i:s', strtotime($meetingStart));
                $meetingEndTime =  date('H:i:s', strtotime($meetingEnd));
                if ((strtotime($meetingStart) - strtotime($now)) > 0) {
                    $meetingDifferenceFromNowInMinutes =  ceil(round(abs(strtotime($meetingStart) - strtotime($now)) /60, 2));
                    if ($meetingDifferenceFromNowInMinutes > 2) {
                        return back()->withInput()->with('error', 'the meeting is allowed to be joined at least 2 minutes before');   
                    }
                }
                $room = $meeting->room_id;
                $inmateToken =  (new TokensGenerating)->generateToken(false, false, $room, false);
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
        $meetingStartTime = $request->session()->get('meetingStartTime');
        $meetingEndTime = $request->session()->get('meetingEndTime');
        $userType = $request->session()->get('user_type');
        $appointment = $meetingInfo->appointment;
        $tariff = $appointment->tariff;
        return view('meetings.visitors.join', compact('meetingInfo','userType','appointment', 'tariff', 'meetingStartTime', 'meetingEndTime'));
    }

    public function invalidateMeeting(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Meeting::find($id)->update([
                'meeting_ended' => true
            ]);
            DB::commit();
            return Response::json([
                'message' => 'data updated'
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'message' => 'data not updated'
            ]);
        }
    }
}
