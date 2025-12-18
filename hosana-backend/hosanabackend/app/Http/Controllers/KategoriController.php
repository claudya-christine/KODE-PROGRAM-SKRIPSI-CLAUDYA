<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(Kategori::all());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($validated);

        return response()->json($kategori, 201);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($validated);

        return response()->json($kategori);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function toggleStatus($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->is_active = !$kategori->is_active;
        $kategori->save();

        return response()->json($kategori);
    }

    public function show($id)
    {
        $kategori = Kategori::withTrashed()->findOrFail($id);

        return response()->json($kategori);
    }

}
