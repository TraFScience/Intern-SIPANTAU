<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use Illuminate\Http\Request;

class KejadianBencanaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'             => 'required|string|max:150',
            'jenis_bencana_id'  => 'required|exists:jenis_bencana,id',
            'wilayah_id'        => 'required|exists:wilayah,id',
            'tanggal_kejadian'  => 'required|date',
            'kecamatan'         => 'nullable|string|max:100',
            'detail_lokasi'     => 'nullable|string',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'jumlah_korban'     => 'nullable|integer|min:0',
            'deskripsi'         => 'nullable|string',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = auth()->id() ?? 1; // Sesuaikan dengan id user login
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kejadian-bencana', 'public');
        }

        KejadianBencana::create($validated);

        return redirect()->back()->with('success', 'Laporan kejadian bencana berhasil disimpan.');
    }
}