<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use App\Models\GuruStaff;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::where('role', 'user')->count(); 
        $totalBerita = Berita::where('is_active', true)->count();
        $totalGuruStaff = GuruStaff::where('is_active', true)->count(); 

        return response()->json([
            'totalUser' => $totalUser,
            'totalBerita' => $totalBerita,
            'totalGuruStaff' => $totalGuruStaff,
        ]);
    }
}
