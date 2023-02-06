<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Jika Menggunakan (__invoke) untul single executeable dan di dalam route tidak perlu menggunakan deklarasi lagii
    public function __invoke()
    {
        return view('welcome');
    }

}