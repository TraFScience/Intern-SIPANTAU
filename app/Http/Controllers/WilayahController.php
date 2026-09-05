<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        return response()->json(Wilayah::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wilayah' => 'required|string|max:150',
            'tipe'         => 'nullable|string|max:50',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
        ]);

        $data = Wilayah::create($validated);

        return response()->json(['message' => 'Wilayah berhasil ditambahkan', 'data' => $data], 201);
    }

    public function show($id)
    {
        return response()->json(Wilayah::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $data = Wilayah::findOrFail($id);
        $validated = $request->validate([
            'nama_wilayah' => 'sometimes|string|max:150',
            'tipe'         => 'nullable|string|max:50',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
        ]);

        $data->update($validated);
        return response()->json(['message' => 'Wilayah diperbarui', 'data' => $data]);
    }

    public function destroy($id)
    {
        Wilayah::destroy($id);
        return response()->json(['message' => 'Wilayah dihapus']);
    }
}
