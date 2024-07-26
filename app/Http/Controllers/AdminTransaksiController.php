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
            $data = Transaksi::with('jenisMotor')->select('transaksi.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('admin.transaksi.edit', $row->id) . '" class="bg-green-600 text-white hover:bg-green-700 rounded px-3 py-2 text-xs flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>';
                    $cetakBtn = '<a href="' . route('transaksi.invoice.preview', $row->id) . '" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 rounded px-3 py-2 text-xs flex items-center justify-center" title="Preview Invoice"><i class="fa-solid fa-eye"></i></a>';

                    return '<div class="flex space-x-2 justify-center">' . $editBtn . $cetakBtn . '</div>';
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" name="transaksi_checkbox[]" class="transaksi_checkbox custom-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('tgl_sewa', function($row) {
                    return $row->tgl_sewa->format('d-m-Y');
                })
                ->addColumn('tgl_kembali', function($row) {
                    return $row->tgl_kembali->format('d-m-Y');
                })
                ->addColumn('jenis_motor_merk', function($row) {
                    return $row->jenisMotor->merk ?? ''; // Adjust if your relationship or field names are different
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

        // Ambil daftar jenis motor
        $jenisMotorList = JenisMotor::whereDoesntHave('transaksi', function($query) {
            $query->whereIn('status', ['disewa', 'perpanjang']);
        })->get();

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

        // Simpan total awal sebelum update
        $originalTotal = $transaksi->total;

        // Simpan tanggal kembali yang asli
        $originalTglKembali = $transaksi->tgl_kembali;

        // Ambil data jenis motor terbaru
        $jenisMotor = JenisMotor::findOrFail($validated['id_jenis']);

        // Hitung jumlah hari perpanjangan dari tanggal kembali yang asli
        $tglSewa = $transaksi->tgl_sewa;
        $tglKembali = $validated['tgl_kembali'];

        // Jika tanggal kembali baru lebih awal dari tanggal kembali asli, tidak perlu perpanjangan
        if ($tglKembali <= $originalTglKembali) {
            return redirect()->back()->with('error', 'Tanggal kembali baru tidak boleh lebih awal dari tanggal kembali asli.');
        }

        // Hitung jumlah hari perpanjangan
        $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($tglKembali);

        // Hitung total harga perpanjangan
        $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotor->harga_perHari;

        // Tambahkan total perpanjangan ke total yang sudah ada
        $totalHargaBaru = $originalTotal + $totalHargaPerpanjangan;

        // Perbarui data transaksi
        $transaksi->tgl_kembali = $validated['tgl_kembali'];
        $transaksi->id_jenis = $validated['id_jenis'];
        $transaksi->total = $totalHargaBaru;
        $transaksi->status = 'perpanjang'; // Atau status sesuai kebutuhan
        $transaksi->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.transaksi.edit', ['transaksi' => $id])->with('success', 'Transaksi berhasil diperbarui.');
    }


    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return response()->json(['success'=>'Transaksi deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Transaksi::whereIn('id', $ids)->delete();
        return response()->json(['success'=>"Transaksi Deleted successfully."]);
    }
}
