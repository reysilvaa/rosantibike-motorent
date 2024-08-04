<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $armada = Stok::all();
        $galeris = Galeri::inRandomOrder()->get(); //random
        return view('landing.landing', compact('armada', 'galeris'));
    }
    public function motorMatic()
    {
        $motors = Stok::all(); // Fetch all Stok records
        return view('landing.assets.navbar-content.motor-matic', compact('motors')); // Ensure you have this view file created
    }
    public function faq()
    {
        return view('landing.assets.navbar-content.faq'); // Ensure you have this view file created
    }
    public function galeri()
    {
        $galeris = Galeri::all();
        return view('landing.assets.landing-content.galeri', compact('galeris')); // Ensure you have this view file created
    }
}
