<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('settings.profile-information', [
            'user' => $request->user()
        ]);
    }
}
