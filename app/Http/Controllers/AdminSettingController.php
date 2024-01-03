<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index(Request $request)
    {
        return view('admins.settings.index');
    }
}
