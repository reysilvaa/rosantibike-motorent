<?php

namespace App\Http\Controllers;

use App\Models\JenisMotor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $armada = JenisMotor::all();
        return view('landing.landing', compact('armada'));
    }
    public function motorMatic()
    {
        // Your logic for the motor-matic landing page
        return view('landing.assets.navbar-content.motor-matic'); // Ensure you have this view file created
    }
}
