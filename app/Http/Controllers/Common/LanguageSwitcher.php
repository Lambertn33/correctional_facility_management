<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageSwitcher extends Controller
{
    public function changeLanguage(Request $request)
    {
        try {
            App::setLocale($request->lang);
            $request->session()->put('locale', $request->lang); 
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
