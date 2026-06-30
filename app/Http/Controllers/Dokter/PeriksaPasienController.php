<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Import DB dipindahkan ke atas dengan benar

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'id_daftar_poli' => 'required',
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        // Decode JSON obat dari view (berisi array ID obat: [1, 2, 3...])
        $obatIds = json_decode($request->obat_json, true);

        if (empty($obatIds)) {
            return redirect()->back()->withInput()->with([
                'message' => 'Gagal menyimpan! Harap pilih minimal satu obat.',
                'type' => 'danger'
            ]);
        }

        // Hitung jumlah kebutuhan masing-masing obat berdasarkan ID yang dipilih
        // Contoh hasil: [ID_Obat_A => 2, ID_Obat_B => 1]
        $obatCounts = array_count_values($obatIds);

        // Menggunakan Database Transaction agar data aman & konsisten jika terjadi error
        DB::beginTransaction();

        try {
            // 2. VALIDASI STOK (Fitur B.1 Handling Stok Habis)
            foreach ($obatCounts as $idObat => $jumlahDibutuhkan) {
                $obat = Obat::find($idObat);

                if (!$obat) {
                    return redirect()->back()->withInput()->with([
                        'message' => 'Gagal menyimpan! Salah satu obat yang dipilih tidak ditemukan.',
                        'type' => 'danger'
                    ]);
                }

                if ($obat->stok < $jumlahDibutuhkan) {
                    // Batalkan proses dan kirim notifikasi error ke view jika stok kurang/habis
                    return redirect()->back()->withInput()->with([
                        'message' => "Gagal menyimpan! Stok obat '{$obat->nama_obat}' tidak mencukupi. Sisa stok: {$obat->stok}, dibutuhkan: {$jumlahDibutuhkan}.",
                        'type' => 'danger'
                    ]);
                }
            }

            // 3. JIKA LOLOS VALIDASI, SIMPAN DATA PERIKSA
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa + 150000,
            ]);

            // 4. SIMPAN DETAIL & PENGURANGAN STOK OTOMATIS (Fitur A.2)
            foreach ($obatIds as $idObat) {
                $obat = Obat::find($idObat);
                
                // Kurangi stok obat sebanyak 1 unit per item
                $obat->decrement('stok', 1);

                // Catat ke tabel detail_periksa
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]);
            }

            // Terapkan semua perubahan ke database jika tidak ada masalah
            DB::commit(); 

            return redirect()->route('periksa-pasien.index')->with([
                'success' => 'Data periksa berhasil disimpan.', // Menjaga kompatibilitas route aslimu
                'message' => 'Data periksa berhasil disimpan, stok obat otomatis terpotong.',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            // Batalkan semua perubahan database jika terjadi error crash sistem
            DB::rollBack(); 
            return redirect()->back()->withInput()->with([
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'type' => 'danger'
            ]);
        }
    }
}