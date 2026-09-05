<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\JenisBencana;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class KejadianBencanaController extends Controller
{
    // 1. Menampilkan semua laporan
    public function index()
    {
        $kejadian = KejadianBencana::with([
            'pelapor',
            'jenisBencana',
            'wilayah'
        ])
        ->latest()
        ->get();

        return view('kejadian-index', compact('kejadian'));
    }

    // 2. Menampilkan form laporan
    public function create()
    {
        $jenisBencana = JenisBencana::all();
        $wilayah = Wilayah::all();

        return view('kejadian-create', compact(
            'jenisBencana',
            'wilayah'
        ));
    }

    // 3. Menyimpan laporan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_bencana_id' => 'required|exists:jenis_bencana,id',
            'wilayah_id'       => 'required|exists:wilayah,id',
            'judul'            => 'required|string|max:150',
            'deskripsi'        => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'gambar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request
                ->file('gambar')
                ->store('bencana', 'public');
        }

        // User yang membuat laporan
        $validated['user_id'] = auth()->id();

        // Status awal laporan
        $validated['status_verifikasi'] = 'menunggu';

        // Simpan ke database
        $kejadian = new KejadianBencana();
        $kejadian->fill($validated);
        $kejadian->save();

        return redirect()
            ->route('kejadian-bencana.index')
            ->with('success', 'Laporan berhasil dikirim!');
    }

    // 4. Menampilkan detail laporan
    public function show($id)
    {
        $kejadian = KejadianBencana::with([
            'pelapor',
            'jenisBencana',
            'wilayah'
        ])->findOrFail($id);

        return view('kejadian.show', compact('kejadian'));
    }

    // 5. Menghapus laporan
    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);
        $kejadian->delete();

        return redirect()
            ->route('kejadian-bencana.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}