<?php

namespace App\Http\Controllers;

use App\Models\UnitPendidikan;
use Illuminate\Http\Request;

class UnitPendidikanController extends Controller
{
    public function index()
    {
        $units = UnitPendidikan::all();
        return response()->json($units);
    }
}
