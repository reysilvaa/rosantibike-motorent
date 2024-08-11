<?php
namespace App\Http\Controllers;

use App\Models\JenisMotor;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function transaksi()
    {
        return view('admin.transaksi.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::with('jenisMotor.stok')->select('transaksi.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('admin.transaksi.edit', $row->id) . '" class="bg-green-600 text-white hover:bg-green-700 rounded px-3 py-2 text-xs flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>';
                    $cetakBtn = '<a href="' . route('transaksi.invoice.preview', ['type' => 'transaksi', 'id' => $row->id]) . '" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 rounded px-3 py-2 text-xs flex items-center justify-center" title="Preview Invoice"><i class="fa-solid fa-eye"></i></a>';
                    return '<div class="flex space-x-2 justify-center">' . $editBtn . $cetakBtn . '</div>';
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" name="transaksi_checkbox[]" class="transaksi_checkbox custom-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('tgl_sewa', function($row) {
                    return $row->tgl_sewa->format('d-m-Y H:i');
                })
                ->addColumn('tgl_kembali', function($row) {
                    return $row->tgl_kembali->format('d-m-Y H:i');
                })
                ->addColumn('merk_motor', function($row) {
                    return $row->jenisMotor->stok->merk ?? '';
                })
                ->addColumn('status', function($row) {
                    return $row->jenisMotor->status ?? '';
                })
                ->addColumn('total', function($row) {
                    return "Rp. " . number_format($row->total, 0, ',', '.');
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        // Temukan transaksi yang akan diedit
        $transaksi = Transaksi::findOrFail($id);

        // Ambil daftar jenis motor yang sedang tidak disewa, tetapi pastikan jenis motor yang sedang diedit tetap ada
        $jenisMotorList = JenisMotor::where(function($query) use ($transaksi) {
            $query->whereDoesntHave('transaksi', function($query) {
                $query->whereIn('status', ['disewa', 'perpanjang']);
            });
        })->orWhere('id', $transaksi->id_jenis)->get();

        // Tampilkan view edit dengan data transaksi dan daftar jenis motor
        return view('admin.transaksi.edit', compact('transaksi', 'jenisMotorList'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'id_jenis' => 'required|exists:jenis_motor,id',
        ]);

        // Temukan transaksi yang akan diperbarui
        $transaksi = Transaksi::findOrFail($id);

        // Simpan tanggal kembali yang asli
        $originalTglKembali = $transaksi->tgl_kembali;

        // Ambil data jenis motor terbaru
        $jenisMotorBaru = JenisMotor::findOrFail($validated['id_jenis']);

        // Cek apakah tanggal kembali berubah
        if ($validated['tgl_kembali'] != $originalTglKembali) {
            // Jika tanggal kembali berubah, hitung perpanjangan
            $tglSewa = $transaksi->tgl_sewa;
            $tglKembali = $validated['tgl_kembali'];

            // Hitung jumlah hari perpanjangan
            $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($tglKembali);

            // Hitung total harga perpanjangan
            $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotorBaru->harga_perHari;

            // Tambahkan total perpanjangan ke total yang sudah ada
            $transaksi->total += $totalHargaPerpanjangan;

            // Perbarui tanggal kembali
            $transaksi->tgl_kembali = $tglKembali;
        }

        // Jika jenis motor berubah
        if ($transaksi->id_jenis != $validated['id_jenis']) {
            // Ubah status jenis motor lama menjadi ready
            $jenisMotorLama = JenisMotor::findOrFail($transaksi->id_jenis);
            $jenisMotorLama->status = 'ready';
            $jenisMotorLama->save();

            // Ubah status jenis motor baru menjadi disewa
            $jenisMotorBaru->status = 'disewa';
            $jenisMotorBaru->save();

            // Perbarui id_jenis pada transaksi
            $transaksi->id_jenis = $validated['id_jenis'];
        }

        // Simpan perubahan transaksi
        $transaksi->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.transaksi.edit', ['transaksi' => $id])->with('success', 'Transaksi berhasil diperbarui.');
    }



    public function destroy(Transaksi $transaksi)
    {
        $jenisMotor = JenisMotor::find($transaksi->id_jenis);

        // Check if JenisMotor exists
        if ($jenisMotor) {
            // Update the status to 'ready'
            $jenisMotor->update(['status' => 'ready']);
        }

        // Delete the transaksi record
        $transaksi->delete();
        return response()->json(['success'=>'Transaksi deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        // Get the IDs from the request
        $ids = $request->ids;

        // Delete the transactions with the specified IDs
        Transaksi::whereIn('id', $ids)->each(function ($transaksi) {
            // Find the JenisMotor associated with the current transaksi
            $jenisMotor = JenisMotor::find($transaksi->id_jenis);

            // Check if JenisMotor exists and update its status
            if ($jenisMotor) {
                $jenisMotor->update(['status' => 'ready']);
            }
        });

        // Delete the transactions after updating JenisMotor statuses
        Transaksi::whereIn('id', $ids)->delete();

        // Return a success response
        return response()->json(['success' => "Transaksi deleted successfully."]);
    }
}
