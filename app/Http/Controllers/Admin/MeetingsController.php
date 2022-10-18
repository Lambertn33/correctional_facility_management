<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Meeting;
use App\Models\Appointment;
use App\Models\Meeting_Token;
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
}
