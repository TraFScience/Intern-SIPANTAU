<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return response()->json(Berita::with('user')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $data = Berita::create($validated);

        return response()->json(['message' => 'Berita berhasil diterbitkan', 'data' => $data], 201);
    }

    public function show($id)
    {
        return response()->json(Berita::with('user')->findOrFail($id));
    }

    public function destroy($id)
    {
        Berita::destroy($id);
        return response()->json(['message' => 'Berita dihapus']);
    }
}
