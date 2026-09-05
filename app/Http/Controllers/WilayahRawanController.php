<?php

namespace App\Http\Controllers;

use App\Models\WilayahRawan;
use Illuminate\Http\Request;

class WilayahRawanController extends Controller
{
    public function index()
    {
        // Mengambil data beserta relasi wilayah dan jenis bencana
        $data = WilayahRawan::with(['wilayah', 'jenisBencana'])->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wilayah_id'       => 'required|exists:wilayah,id',
            'jenis_bencana_id' => 'required|exists:jenis_bencana,id',
            'tingkat_rawan'    => 'required|string|max:20',
            'keterangan'       => 'nullable|string',
        ]);

        $data = WilayahRawan::create($validated);

        return response()->json(['message' => 'Wilayah rawan berhasil ditambahkan', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        WilayahRawan::destroy($id);
        return response()->json(['message' => 'Wilayah rawan dihapus']);
    }
}
