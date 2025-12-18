<?php

namespace App\Http\Controllers;

use App\Models\GuruStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruStaffController extends Controller
{
        public function index(Request $request)
        {
            $query = GuruStaff::with('unit')->where('is_active', true);

            if ($request->has('unit')) {
                $query->whereHas('unit', function ($q) use ($request) {
                    $q->where('pendidikan', $request->unit);
                });
            }

            return response()->json($query->paginate(5));
        }

     public function all(Request $request)
    {
        $query = GuruStaff::with('unit')->where('is_active', true);

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
        'staffID' => 'required|string|unique:gurustaff,staffID',
        'namalengkap' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'posisi' => 'required|string|max:100',
        'unit_id' => 'required|exists:unit_pendidikan,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('guru', 'public');
        $validated['image'] = $path;
    }

    $gurustaff = GuruStaff::create($validated);

    return response()->json($gurustaff, 201);
}


    public function show($staffID)
    {
        $gurustaff = GuruStaff::withTrashed()->findOrFail($staffID);
        return response()->json($gurustaff);
    }

    public function update(Request $request, $staffID)
    {
        $gurustaff = GuruStaff::findOrFail($staffID);

        $validated = $request->validate([
            'staffID' => 'sometimes|string|unique:gurustaff,staffID,' . $staffID . ',staffID',
            'namalengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'posisi' => 'required|string|max:100',
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($gurustaff->image) {
                Storage::disk('public')->delete($gurustaff->image);
            }

            $path = $request->file('image')->store('guru', 'public');
            $validated['image'] = $path;
        }

        $gurustaff->update($validated);

        return response()->json($gurustaff);
    }



    public function destroy($staffID)
    {
        $gurustaff = GuruStaff::findOrFail($staffID);
        $gurustaff->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
