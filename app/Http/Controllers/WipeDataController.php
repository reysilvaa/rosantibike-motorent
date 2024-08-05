<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Galeri;
use App\Models\JenisMotor;
use App\Models\Rating;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class WipeDataController extends Controller
{
    /**
     * Show the wipe data form.
     */
    public function index()
    {
        return view('admin.wipedata.index');
    }

    /**
     * Handle the data wipe request.
     */
    public function wipe(Request $request)
    {
        $models = $request->input('models', []);

        if (empty($models)) {
            return redirect()->back()->with('error', 'No models specified.');
        }

        try {
            foreach ($models as $model) {
                switch ($model) {
                    case 'jenis_motor':
                        JenisMotor::query()->delete(); // Menggunakan delete() alih-alih truncate()
                        break;

                    case 'transaksi':
                        Transaksi::query()->delete(); // Menggunakan delete() alih-alih truncate()
                        break;

                    case 'booking':
                        Booking::query()->delete(); // Menggunakan delete() alih-alih truncate()
                        break;

                    case 'galeri':
                        Galeri::query()->delete(); // Menggunakan delete() alih-alih truncate()
                        break;

                    case 'rating':
                        Rating::query()->delete(); // Menggunakan delete() alih-alih truncate()
                        break;

                    default:
                        // Optionally, log or handle unknown models here
                        break;
                }
            }

            return redirect()->back()->with('success', 'Data wiped successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
