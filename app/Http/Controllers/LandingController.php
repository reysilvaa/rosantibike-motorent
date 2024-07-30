<?php

namespace App\Http\Controllers;

use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $armada = Stok::all();
        return view('landing.landing', compact('armada'));
    }
    public function motorMatic()
    {
        $motors = Stok::all(); // Fetch all Stok records
        return view('landing.assets.navbar-content.motor-matic', compact('motors')); // Ensure you have this view file created
    }
}
