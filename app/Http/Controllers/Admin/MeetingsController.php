<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

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
}
