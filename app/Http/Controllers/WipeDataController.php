<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Transaksi;

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
                        JenisMotor::truncate();
                        break;

                    case 'transaksi':
                        Transaksi::truncate();
                        break;

                    case 'booking':
                        Booking::truncate();
                        break;

                    // No action needed for unknown models, just skip to the next iteration
                    default:
                        break;
                }
            }

            return redirect()->back()->with('success', 'Data wiped successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
