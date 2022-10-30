<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\Videos\RoomsService;
use App\Http\Services\Common\Videos\TokensGenerating;
use Illuminate\Http\Request;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MeetingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getAllMeetings()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $allMeetings = Meeting::with('meetingCodes')->whereHas('appointment', function($query) use($currentPrison){
            $query->where('prison_id', $currentPrison->id);
        })->get();
        return view('admin.meetings.index', compact('currentPrison','allMeetings','authenticatedUser'));
    }

    public function getSpecificMeeting($id)
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;

        $currentMeeting = Meeting::with('meetingCodes')->with('appointment')->find($id);
        return view('admin.meetings.show', compact('currentPrison','currentMeeting','authenticatedUser'));
    }

    public function generateAdminToken(Request $request, $id) {
        $currentMeeting = Meeting::with('meetingCodes')->with('appointment')->find($id);
        $room = $currentMeeting->room_id;
        $adminToken = (new TokensGenerating)->generateToken(false, false, $room, true);
        $currentMeetingCodes = $currentMeeting->meetingCodes;
        try {
           $currentMeetingCodes->update([
            'admin_token' => $adminToken
           ]);
        $request->session()->put('meetingToJoin', $currentMeeting);
        return redirect()->route('adminJoinMeeting', $id);
        } catch (\Throwable $th) {
            return back()->with('danger', 'an error occured.. please try again');
        }
    }

    public function joinMeeting(Request $request) {
        if (!$request->session()->has('meetingToJoin')) {
            return back();
        }
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $meetingToJoin = $request->session()->get('meetingToJoin');
        $meetingStart = $meetingToJoin->appointment->from;
        $meetingEnd = $meetingToJoin->appointment->to;
        $meetingStartTime =  strtotime($meetingStart);
        $meetingEndTime =  strtotime($meetingEnd);
        $inmate = $meetingToJoin->appointment->inmate->names;
        $visitor = $meetingToJoin->appointment->names;
        return view('admin.meetings.joinMeeting', compact('currentPrison', 'meetingToJoin', 'authenticatedUser', 'inmate', 'visitor', 'meetingEndTime'));
    }

    public function endMeeting(Request $request) {
        $meetingToEndId = $request->meetingId;
        $meetingToEnd = Meeting::with('meetingCodes')->with('appointment')->find($meetingToEndId);
        try {
            DB::beginTransaction();
            (new RoomsService)->endSpecificRoom($meetingToEnd->room_id);
            $meetingToEnd->update([
                'meeting_ended' => true
            ]);
            DB::commit();
            $request->session()->forget('meetingToJoin');
            return response()->json([
                'status' => 200,
                'message' => 'ended and updated...'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => 'error...'
            ]);
        }
    }
}
