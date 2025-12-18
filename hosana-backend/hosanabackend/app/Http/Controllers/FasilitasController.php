<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fasilitas::with('unit')->where('is_active', true);

        if ($request->has('unit')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('pendidikan', $request->unit);
            });
        }
        return response()->json($query->paginate(3));
    }
    public function all(Request $request) 
    {
        $query = Fasilitas::with('unit')->where('is_active', true);

        if ($request->has('unit')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('pendidikan', $request->unit);
            });
        }

        return response()->json($query->latest()->get()); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaFasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'unit_id' => 'required|exists:unit_pendidikan,id',
        ]);

        $path = $request->file('image')->store('fasilitas', 'public');

        $fasilitas = Fasilitas::create([
            'namaFasilitas' => $validated['namaFasilitas'],
            'deskripsi' => $validated['deskripsi'],
            'unit_id' => $validated['unit_id'],
            'image' => $path,
            'is_active' => true,
        ]);

        return response()->json($fasilitas, 201);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'namaFasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($fasilitas->image);
            $path = $request->file('image')->store('fasilitas', 'public');
            $fasilitas->image = $path;
        }

        $fasilitas->namaFasilitas = $validated['namaFasilitas'];
        $fasilitas->deskripsi = $validated['deskripsi'];
        $fasilitas->unit_id = $validated['unit_id'];
        $fasilitas->is_active = $validated['is_active'] ?? $fasilitas->is_active;

        $fasilitas->save();

        return response()->json([
            'message' => 'Fasilitas updated successfully',
            'fasilitas' => $fasilitas
        ]);
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        Storage::disk('public')->delete($fasilitas->image);
        $fasilitas->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::withTrashed()->findOrFail($id);
        return response()->json($fasilitas);
    }
}
