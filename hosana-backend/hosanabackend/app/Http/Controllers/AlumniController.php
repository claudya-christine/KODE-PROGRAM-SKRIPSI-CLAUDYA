<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
public function index(Request $request)
{
    $query = Alumni::with('unit')->where('is_active', true);

    if ($request->has('unit')) {
        $query->whereHas('unit', function ($q) use ($request) {
            $q->where('pendidikan', $request->unit);
        });
    }

    return response()->json($query->paginate(5));
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'generasi' => 'required|integer',
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'link' => 'required|string',
        ]);

        $alumni = Alumni::create($validated);

        return response()->json($alumni, 201);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validated = $request->validate([
            'generasi' => 'required|integer',
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'link' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $alumni->update($validated);

        return response()->json($alumni);
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return response()->json(['message' => 'Alumni berhasil dihapus']);
    }

    public function show($id)
    {
        $alumni = Alumni::withTrashed()->findOrFail($id);

        return response()->json($alumni);
    }

}
