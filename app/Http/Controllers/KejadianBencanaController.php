<?php

namespace App\Http\Controllers;

use App\Models\KejadianBencana;
use App\Models\JenisBencana;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KejadianBencanaController extends Controller
{
    public function index()
    {
        $kejadian = KejadianBencana::with(['jenisBencana', 'wilayah'])->latest()->get();
        return view('kejadian-index', compact('kejadian'));
    }

    public function create()
    {
        $jenisBencana = JenisBencana::all();
        $wilayah = Wilayah::all();

        return view('kejadian-bencana.lapor', compact('jenisBencana', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'             => 'required|string|max:150',
            'jenis_bencana_id'  => 'required|exists:jenis_bencana,id',
            'wilayah_id'        => 'required|exists:wilayah,id',
            'tanggal_kejadian'  => 'required|date',
            'kecamatan'         => 'nullable|string|max:100',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'deskripsi'         => 'nullable|string',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = Auth::id() ?? 1; // Sesuaikan dengan id user login

        if (Auth::check() && Auth::user()->role === 'petugas') {
            $validated['status_verifikasi'] = 'terverifikasi';
            $validated['verified_id'] = Auth::id();
        } else {
            $validated['status_verifikasi'] = 'menunggu';
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kejadian-bencana', 'public');
        }

        KejadianBencana::create($validated);

        return redirect()->back()->with('success', 'Laporan kejadian bencana berhasil disimpan.');
    }

    public function show($id)
    {
        $kejadian = KejadianBencana::with(['jenisBencana', 'wilayah'])->findOrFail($id);
        return view('kejadian-bencana.show', compact('kejadian'));
    }

    public function edit($id)
    {
        $kejadian     = KejadianBencana::findOrFail($id);
        $jenisBencana = JenisBencana::all();
        $wilayah      = Wilayah::all();

        return view('kejadian-bencana.edit', compact('kejadian', 'jenisBencana', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        $validated = $request->validate([
            'judul'             => 'required|string|max:150',
            'jenis_bencana_id'  => 'required|exists:jenis_bencana,id',
            'wilayah_id'        => 'required|exists:wilayah,id',
            'tanggal_kejadian'  => 'required|date',
            'kecamatan'         => 'nullable|string|max:100',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'deskripsi'         => 'nullable|string',
            'gambar'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kejadian-bencana', 'public');
        }

        $kejadian->update($validated);

        return redirect()->route('admin.kelola-bencana')->with('success', 'Data kejadian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);
        $kejadian->delete();

        return redirect()->back()->with('success', 'Data kejadian berhasil dihapus.');
    }

    public function verifikasi($id)
    {
        $kejadian = KejadianBencana::findOrFail($id);

        $kejadian->update([
            'status_verifikasi' => 'terverifikasi',
            'verified_id'        => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Kejadian berhasil diverifikasi.');
    }
}
