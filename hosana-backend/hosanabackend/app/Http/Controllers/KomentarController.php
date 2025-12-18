<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
public function index($beritaId)
{
    return response()->json(
        \App\Models\Komentar::with(['user', 'tanggapan.admin']) 
            ->where('berita_id', $beritaId)
            ->where('status', 'approved')
            ->latest()
            ->get()

    );
}


    public function store(Request $request)
    {
        $request->validate([
            'berita_id' => 'required|exists:beritas,id',
            'isi_komentar' => 'required',
        ]);

        Komentar::create([
            'berita_id' => $request->berita_id,
            'user_id' => auth()->id(),
            'isi_komentar' => $request->isi_komentar,
            'status' => 'pending',
        ]);


        return response()->json(['message' => 'Komentar berhasil ditambahkan']);
    }

public function destroy($id)
{
    $komentar = Komentar::find($id);

    if (!$komentar) {
        return response()->json(['message' => 'Komentar tidak ditemukan'], 404);
    }

    $user = auth()->user();

    if ($user->role !== 'admin' && $komentar->user_id !== $user->id) {
        return response()->json(['message' => 'Kamu tidak punya izin untuk menghapus komentar ini'], 403);
    }

    $komentar->tanggapan()->delete();

    $komentar->delete();

    return response()->json(['message' => 'Komentar dan tanggapannya berhasil dihapus']);
}

public function approve($id)
{
    $user = auth()->user();

    if ($user->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $komentar = Komentar::findOrFail($id);

    $komentar->update([
        'status' => 'approved'
    ]);

    return response()->json(['message' => 'Komentar berhasil disetujui']);
}
    

}

