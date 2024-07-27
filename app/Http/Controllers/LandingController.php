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
}
