<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paket;
use Carbon\Carbon;

class PaketController extends Controller
{
    private function getStats()
    {
        return [
            'total_semua' => Paket::count(),
            'hari' => Paket::whereDate('tanggal', Carbon::today())->count(),
            'minggu' => Paket::whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'bulan' => Paket::whereMonth('tanggal', Carbon::now()->month)->count(),
            'belum' => Paket::where('status_paket', '0')->count(),
            'selesai' => Paket::where('status_paket', '1')->count(),
            'bulanIndo' => [
                1=>'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember'
            ]
        ];
    }

    public function semua(Request $request)
    {
        $stats = $this->getStats();
        
        $query = Paket::query();
        if ($request->tgl1 && $request->tgl2) {
            $query->whereBetween(DB::raw('DATE(tanggal)'), [$request->tgl1, $request->tgl2]);
        }
        $stats['data'] = $query->orderBy('id', 'desc')->get();
        $stats['halaman'] = 'total_paket.php'; // Keeping legacy variable names for Blade refactoring

        return view('admin.total_paket', $stats);
    }

    public function dashboard()
    {
        $stats = $this->getStats();
        $stats['data'] = Paket::whereDate('tanggal', Carbon::today())->orderBy('tanggal', 'desc')->get();
        $stats['halaman'] = 'paket_harian.php';

        return view('admin.paket_harian', $stats);
    }

    public function mingguan()
    {
        $stats = $this->getStats();
        $stats['data'] = Paket::whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('tanggal', 'desc')->get();
        $stats['halaman'] = 'paket_mingguan.php';

        return view('admin.paket_mingguan', $stats);
    }

    public function bulanan()
    {
        $stats = $this->getStats();
        $stats['data'] = Paket::whereMonth('tanggal', Carbon::now()->month)->orderBy('tanggal', 'desc')->get();
        $stats['halaman'] = 'paket_bulanan.php';

        return view('admin.paket_bulanan', $stats);
    }

    public function belumKonfirmasi(Request $request)
    {
        $stats = $this->getStats();
        $query = Paket::where('status_paket', '0');
        if ($request->tgl1 && $request->tgl2) {
            $query->whereBetween(DB::raw('DATE(tanggal)'), [$request->tgl1, $request->tgl2]);
        }
        $stats['data'] = $query->orderBy('tanggal', 'desc')->get();
        $stats['halaman'] = 'paket_blm_konfirmasi.php';

        return view('admin.paket_blm_konfirmasi', $stats);
    }

    public function selesai(Request $request)
    {
        $stats = $this->getStats();
        $query = Paket::where('status_paket', '1');
        if ($request->tgl1 && $request->tgl2) {
            $query->whereBetween(DB::raw('DATE(tanggal)'), [$request->tgl1, $request->tgl2]);
        }
        $stats['data'] = $query->orderBy('tanggal', 'desc')->get();
        $stats['halaman'] = 'selesai.php';

        return view('admin.selesai', $stats);
    }

    public function konfirmasiStatus($id, $status)
    {
        $paket = Paket::findOrFail($id);
        $paket->status_paket = $status;
        $paket->save();

        return back();
    }

    public function kirimPeringatan($id)
    {
        $paket = Paket::findOrFail($id);

        $tgl = \Carbon\Carbon::parse($paket->tanggal);
        $bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tanggal = $tgl->format('d ') . $bulanIndo[$tgl->format('n')] . $tgl->format(' Y');
        $jam = $tgl->format('H:i');
        
        $codText = $paket->status_cod == 1 ? "COD" : "Non COD";
        $hargaFormat = number_format($paket->harga_cod, 0, ',', '.');
        
        $pesan = "Halo {$paket->nama_penerima},\npaket Anda belum diambil dari Pos Satpam di lobby utama.\nStatus: {$codText}\nHarga COD: Rp {$hargaFormat}\nTanggal: {$tanggal} {$jam}\nSilakan segera diambil.";

        $gowaEndpoint = env('GOWA_ENDPOINT', 'http://localhost:3000/send/message');
        $gowaDevice = env('GOWA_DEVICE');

        try {
            \Illuminate\Support\Facades\Http::withHeaders([
                'X-Device-Id' => $gowaDevice
            ])->post($gowaEndpoint, [
                'phone' => $paket->no_wa,
                'message' => $pesan
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim peringatan WA: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim pesan WhatsApp. Pastikan service GOWA berjalan.');
        }

        return back()->with('success', 'Peringatan berhasil dikirim ke WhatsApp ' . $paket->nama_penerima);
    }

    public function exportExcel($filter)
    {
        // Placeholder for export logic. The actual views can just loop over queries.
        // It's usually better to use Maatwebsite/Laravel-Excel, but for simple migration,
        // we can just return a view with headers set to excel.
        
        $query = Paket::query();
        
        if ($filter == 'hari') {
            $query->whereDate('tanggal', Carbon::today());
        } elseif ($filter == 'minggu') {
            $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'bulan') {
            $query->whereMonth('tanggal', Carbon::now()->month);
        } elseif ($filter == 'belum') {
            $query->where('status_paket', '0');
        } elseif ($filter == 'selesai') {
            $query->where('status_paket', '1');
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.export_excel', compact('data', 'filter'));
    }
}
