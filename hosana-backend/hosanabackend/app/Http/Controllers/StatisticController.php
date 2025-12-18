<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\GuruStaff;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistic = Statistic::first();

        $totalGuruStaff = GuruStaff::count();

        return response()->json([
            'id' => $statistic->id,
            'total_alumni' => $statistic->total_alumni,
            'total_siswa' => $statistic->total_siswa,
            'total_guru_staff' => $totalGuruStaff,
        ]);
    }

    public function store(Request $request)
    {
        $totalGuruStaff = GuruStaff::count();

        $validated = $request->validate([
            'total_siswa' => 'required|integer|min:0',
            'total_alumni' => 'required|integer|min:0',
        ]);

        $validated['total_guru_staff'] = $totalGuruStaff;

        $statistic = Statistic::create($validated);

        return response()->json([
            'message' => 'Data statistik berhasil ditambahkan',
            'data' => $statistic
        ], 201);
    }

    public function show($id)
    {
        $statistic = Statistic::find($id);

        if (!$statistic) {
            return response()->json(['message' => 'Data statistik tidak ditemukan'], 404);
        }

        $statistic->total_guru_staff = GuruStaff::count();

        return response()->json($statistic);
    }

    public function update(Request $request, $id)
    {
        $totalGuruStaff = GuruStaff::count();

        $validated = $request->validate([
            'total_siswa' => 'required|integer|min:0',
            'total_alumni' => 'required|integer|min:0',
        ]);

        $validated['total_guru_staff'] = $totalGuruStaff;

        $statistic = Statistic::findOrFail($id);
        $statistic->update($validated);

        return response()->json([
            'message' => 'Data statistik berhasil diperbarui',
            'data' => $statistic
        ]);
    }
}
