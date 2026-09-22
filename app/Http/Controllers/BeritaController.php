<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('user')->latest()->get();

        return view('berita.index', compact('berita'));
    }

    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'nullable|exists:users,id',
            'judul'    => 'required|string|max:150',
            'isi'      => 'required|string',
            'kategori' => 'nullable|string|max:50',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal'  => 'required|date',
        ]);

        $validated['user_id'] = $request->user_id ?? auth()->id() ?? 1;

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($validated);

        return redirect()->route('admin.kelola-berita')
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function show($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        $beritaTerkait = Berita::where('id', '!=', $id)->latest()->take(4)->get();

        return view('berita.show', compact('berita', 'beritaTerkait'));
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul'    => 'required|string|max:150',
            'isi'      => 'required|string',
            'kategori' => 'nullable|string|max:50',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal'  => 'required|date',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($validated);

        return redirect()->route('admin.kelola-berita')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.kelola-berita')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
