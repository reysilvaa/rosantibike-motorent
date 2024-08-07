<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\JenisMotor;
use App\Models\Rating;
use App\Models\Stok;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $armada = Stok::all();
        $galeris = Galeri::inRandomOrder()->get(); //random
        $reviews = Rating::all(); // Fetch all reviews
        return view('landing.landing', compact('armada', 'galeris', 'reviews'));
    }
    public function motorMatic()
    {
        $motors = Stok::where('kategori', 'matic')->get(); // Fetch all Stok records
        return view('landing.assets.navbar-content.motor-matic', compact('motors')); // Ensure you have this view file created
    }

    public function motorManual()
    {
        $motors = Stok::where('kategori', 'manual')->get(); // Fetch all Stok records
        return view('landing.assets.navbar-content.motor-manual', compact('motors')); // Ensure you have this view file created
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
    public function testimoni(){

    $reviews = Rating::all(); // Fetch all reviews
    return view('landing.assets.landing-content.testimoni', compact('reviews'));
    }
}
