<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with('unit')->where('is_active', true);

        if ($request->has('unit')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('pendidikan', $request->unit);
            });
        }
        return response()->json($query->paginate(3));
    }

        public function all(Request $request) 
    {
        $query = Kegiatan::with('unit')->where('is_active', true);

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
            'namaKegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'unit_id' => 'required|exists:unit_pendidikan,id',
        ]);

        $path = $request->file('image')->store('kegiatan', 'public');

        $kegiatan = Kegiatan::create([
            'namaKegiatan' => $validated['namaKegiatan'],
            'deskripsi' => $validated['deskripsi'],
            'unit_id' => $validated['unit_id'],
            'image' => $path,
            'is_active' => true,
        ]);

        return response()->json($kegiatan, 201);
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate([
            'namaKegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($kegiatan->image);
            $path = $request->file('image')->store('kegiatan', 'public');
            $kegiatan->image = $path;
        }

        $kegiatan->namaKegiatan = $validated['namaKegiatan'];
        $kegiatan->deskripsi = $validated['deskripsi'];
        $kegiatan->unit_id = $validated['unit_id'];
        $kegiatan->is_active = $validated['is_active'] ?? $kegiatan->is_active;

        $kegiatan->save();

        return response()->json([
            'message' => 'kegiatan updated successfully',
            'kegiatan' => $kegiatan
        ]);
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        Storage::disk('public')->delete($kegiatan->image);
        $kegiatan->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::withTrashed()->findOrFail($id);
        return response()->json($kegiatan);
    }
}
