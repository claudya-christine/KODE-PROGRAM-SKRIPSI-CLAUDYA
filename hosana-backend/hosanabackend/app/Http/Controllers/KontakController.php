<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{

    public function index()
    {
        return response()->json(Kontak::all());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'noTelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $kontak = Kontak::create($validated);

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data' => $kontak
        ], 201);
    }

    public function show($id)
    {
        $kontak = Kontak::find($id);

        if (!$kontak) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($kontak);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'noTelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $kontak = Kontak::findOrFail($id);
        $kontak->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $kontak
        ]);
    }


}
