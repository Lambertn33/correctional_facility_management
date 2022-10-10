<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Common\ValidateInputs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Inmate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InmatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getPrisonInmates()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $currentPrisonInmates = $currentPrison->inmates()->get();
        return view('admin.inmates.index', compact('currentPrison','currentPrisonInmates','authenticatedUser'));
    }

    public function createNewPrisonInmate()
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        return view('admin.inmates.create', compact('currentPrison','authenticatedUser'));
    }

    public function saveNewPrisonInmate(Request $request)
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $data = $request->all();
         try {
            DB::beginTransaction();
            if (!(new ValidateInputs)->validateNationalIDLength($data['national_id'])) {
                return back()->withInput()->with('error','The national ID Must consists of 16 digits');
            }
            if ((new ValidateInputs)->validateInmateNationalIDExistence($data['national_id'], $currentPrison->id)) {
                return back()->withInput()->with('error','The national ID Provided is already registered');
            }
            if ((new ValidateInputs)->validateInmateCode($data['code'])) {
                return back()->withInput()->with('error','The code provided has been already taken');
            }
    
            $newInmate = [
                'id' => Str::uuid()->toString(),
                'national_id' => $data['national_id'],
                'names' => $data['names'],
                'in_date' => $data['date'],
                'prison_id' => $currentPrison->id,
                'father_names' => $data['father_names'],
                'mother_names' => $data['mother_names'],
                'inmate_code' => $data['code'],
                'reason' => $data['reason'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            Inmate::insert($newInmate);
            DB::commit();
            return redirect()->route('getPrisonInmates')->with('success', 'new Inmate saved successfully');
         } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('error','an error occured....please try again');
         }
    }

    public function editPrisonInmate($id)
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $inmateToEdit = Inmate::find($id);
        return view('admin.inmates.edit', compact('currentPrison','authenticatedUser', 'inmateToEdit'));
    }

    public function updatePrisonInmate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Inmate::find($id)->update([
                'data' => $request->date,
                'status' => $request->status,
                'reason' => $request->reason
            ]);
            DB::commit();
            return redirect()->route('getPrisonInmates')->with('success', 'Inmate updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('error','an error occured....please try again');
        }
        return $request->all();
    }
}
