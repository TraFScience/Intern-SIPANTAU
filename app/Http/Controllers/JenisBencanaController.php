<?php
namespace App\Http\Controllers;

use App\Models\JenisBencana;
use Illuminate\Http\Request;

class JenisBencanaController extends Controller
{
    public function index()
    {
        return response()->json(JenisBencana::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
        ]);

        $data = JenisBencana::create($validated);

        return response()->json(['message' => 'Jenis bencana berhasil ditambahkan', 'data' => $data], 201);
    }

    public function show($id)
    {
        $data = JenisBencana::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = JenisBencana::findOrFail($id);
        $validated = $request->validate([
            'nama_jenis' => 'sometimes|string|max:100',
            'deskripsi'  => 'nullable|string',
        ]);

        $data->update($validated);
        return response()->json(['message' => 'Jenis bencana diperbarui', 'data' => $data]);
    }

    public function destroy($id)
    {
        JenisBencana::destroy($id);
        return response()->json(['message' => 'Jenis bencana dihapus']);
    }
}