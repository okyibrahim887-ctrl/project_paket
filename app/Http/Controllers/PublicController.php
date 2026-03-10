<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use Illuminate\Support\Facades\Http;

class PublicController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_wa' => 'required',
            'nama_satpam' => 'required',
            'cod' => 'required',
        ]);

        $no_wa = $request->no_wa;
        
        // Format nomor WA agar selalu menjadi +628...
        // Hapus karakter selain angka dan tanda +
        $no_wa = preg_replace('/[^0-9+]/', '', $no_wa);
        
        // Jika dimulai dengan 08
        if (substr($no_wa, 0, 2) == "08") {
            $no_wa = "+62" . substr($no_wa, 1);
        }
        // Jika dimulai dengan 62 (tanpa plus)
        elseif (substr($no_wa, 0, 2) == "62") {
            $no_wa = "+" . $no_wa;
        }

        $harga_cod = $request->has('harga_cod') ? $request->harga_cod : 0;

        Paket::create([
            'nama_penerima' => $request->nama,
            'no_wa' => $no_wa,
            'nama_satpam' => $request->nama_satpam,
            'status_cod' => $request->cod,
            'harga_cod' => $harga_cod,
            'catatan' => $request->catatan,
            'status_paket' => '0',
            'tanggal' => now()
        ]);

        $status_cod_text = ($request->cod == 1) ? "COD Rp " . number_format($harga_cod, 0, ',', '.') : "Non COD";

        $pesan = "Halo {$request->nama},\nPaket Anda telah sampai di lobby utama.\nStatus: {$status_cod_text}\nDiterima oleh: {$request->nama_satpam}\nCatatan: {$request->catatan}\nSilakan segera diambil.";

        $gowaEndpoint = env('GOWA_ENDPOINT', 'http://localhost:3000/send/message');
        $gowaDevice = env('GOWA_DEVICE');

        try {
            Http::withHeaders([
                'X-Device-Id' => $gowaDevice
            ])->post($gowaEndpoint, [
                'phone' => $no_wa,
                'message' => $pesan
            ]);
        } catch (\Exception $e) {
            // Tulis ke log jika gagal
            \Illuminate\Support\Facades\Log::error('Gagal mengirim WA: ' . $e->getMessage());
        }

        return redirect('/')->with('success', 'Paket berhasil disimpan dan pesan WhatsApp telah dikirim ke penerima.');
    }
}
