<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        // 1. Tambahkan validasi untuk 'stok' saat membuat obat baru
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0', 
        ], [
            'harga.min' => 'Harga tidak boleh minus!',
            'stok.min' => 'Stok awal tidak boleh minus!',
        ]);

        // 2. Masukkan field 'stok' ke dalam query create
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok, 
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat Berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit')->with([
            'obat' => $obat
        ]);
    }

    public function update(Request $request, string $id)
    {
        // 3. Tambahkan validasi untuk 'stok' di fungsi update utama
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0', 
        ], [
            'harga.min' => 'Harga tidak boleh minus!',
            'stok.min' => 'Stok tidak boleh minus!',
        ]);

        $obat = Obat::findOrFail($id);
        
        // 4. Perbarui data 'stok' di database
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok, 
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    // Method ini tetap aman digunakan jika sewaktu-waktu kamu butuh update stok instan/terpisah
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ], [
            'stok.min' => 'Stok tidak boleh minus!',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'stok' => $request->stok
        ]);

        return redirect()->back()->with([
            'message' => "Stok obat {$obat->nama_obat} berhasil diperbarui menjadi {$request->stok}.",
            'type' => 'success'
        ]);
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di Hapus')
            ->with('type', 'success');
    }
}