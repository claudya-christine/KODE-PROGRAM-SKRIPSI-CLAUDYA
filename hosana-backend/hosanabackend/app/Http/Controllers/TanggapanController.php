<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'komentar_id' => 'required|exists:komentars,id',
            'isi' => 'required|string',
        ]);

        $tanggapan = Tanggapan::create([
            'komentar_id' => $request->komentar_id,
            'admin_id' => auth()->user()->id, 
            'isi' => $request->isi,
        ]);

        return response()->json($tanggapan->load('admin'));
    }

    public function index($komentarId)
    {
        return Tanggapan::with('admin')
            ->where('komentar_id', $komentarId)
            ->get();
    }

    public function destroy($id)
{
    $tanggapan = Tanggapan::find($id);

    if (!$tanggapan) {
        return response()->json(['message' => 'Tanggapan tidak ditemukan'], 404);
    }

    $tanggapan->delete();

    return response()->json(['message' => 'Tanggapan berhasil dihapus']);
}

}
