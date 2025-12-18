<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\MediaBerita;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class BeritaController extends Controller
{
public function index(Request $request)
{
    $query = Berita::with(['kategoris', 'media'])
        ->where('is_active', true);

    // SEARCH BERDASARKAN JUDUL / ISI
    if ($request->has('search') && $request->search !== '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%$search%")
              ->orWhere('isi', 'like', "%$search%");
        });
    }

    $beritas = $query->paginate(5);

    return response()->json($beritas);
}

    public function all()
{
    $beritas = Berita::with(['kategoris', 'media'])
        ->where('is_active', true)
        ->latest()
        ->get(); 

    return response()->json($beritas);
}



public function downloadPDF()
{
    Carbon::setLocale('id');
    $berita = Berita::with('kategoris')
    ->whereDate('tanggal_berita', Carbon::today()->toDateString())
    ->orderBy('created_at', 'desc')->get();

    //
    $pdf = Pdf::loadView('pdf.berita', compact('berita'));
    return $pdf->download('Daftar_Berita.pdf');
}


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_berita' => 'required|date',
            'kategori_id' => 'required|array',
            'kategori_id.*' => 'exists:kategoris,id',
            'media.*' => 'nullable|mimes:jpg,jpeg,png,mp4|max:10240'
        ]);

        DB::beginTransaction();

        try {
            $berita = Berita::create($request->only(['judul', 'isi', 'tanggal_berita']));

            $berita->kategoris()->sync($request->kategori_id);

            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('uploads/media', 'public');
                    $tipe = $file->getClientOriginalExtension() === 'mp4' ? 'video' : 'foto';

                    MediaBerita::create([
                        'berita_id' => $berita->id,
                        'file_path' => $path,
                        'tipe' => $tipe,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Berita berhasil ditambahkan', 'data' => $berita->load('kategoris', 'media')], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    } 

public function show($id)
{
    $berita = Berita::with([
        'media',
        'kategoris',
        'komentar.user',        
        'komentar.tanggapan.admin'
    ])->findOrFail($id);

    return response()->json($berita);
}

    public function update(Request $request, $id)
{
    $berita = Berita::findOrFail($id);

    $request->validate([
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'tanggal_berita' => 'required|date',
        'kategori_id' => 'array',
        'kategori_id.*' => 'exists:kategoris,id',
        'media.*' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
    ]);

    DB::beginTransaction();
    try {
        $berita->update($request->only(['judul', 'isi', 'tanggal_berita', 'is_active']));

        if ($request->has('kategori_id')) {
            $berita->kategoris()->sync($request->kategori_id);
        }

        if ($request->hasFile('media')) {
            foreach ($berita->media as $oldMedia) {
                Storage::disk('public')->delete($oldMedia->file_path);
                $oldMedia->delete();
            }

            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads/media', 'public');
                $tipe = $file->getClientOriginalExtension() === 'mp4' ? 'video' : 'foto';

                MediaBerita::create([
                    'berita_id' => $berita->id,
                    'file_path' => $path,
                    'tipe' => $tipe,
                ]);
            }
        }

        DB::commit();
        return response()->json([
            'message' => 'Berita berhasil diperbarui',
            'data' => $berita->load('kategoris', 'media'),
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}

public function withKomentar() {
    $beritas = Berita::with(['komentar' => function($q) {
            $q->whereNull('deleted_at'); 
        }, 'media', 'kategoris'])
        ->where('is_active', true)
        ->whereHas('komentar', function($q) {
            $q->whereNull('deleted_at'); 
        })
        ->paginate(6);

    return response()->json($beritas);
}

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete(); 

        return response()->json(['message' => 'Berita berhasil dihapus (soft delete)']);
    }

    public function restore($id)
    {
        $berita = Berita::onlyTrashed()->findOrFail($id);
        $berita->restore();

        return response()->json(['message' => 'Berita berhasil dikembalikan']);
    }
}


    // ->latest('tanggal_berita')
    //     ->take(1)
    //     ->get();

    // ->whereDate('tanggal_berita', Carbon::today())
    //     ->orderBy('tanggal_berita', 'desc')
    //     ->get();

    // ->whereBetween('tanggal_berita', ['2025-11-01', '2025-11-10'])
    // ->orderBy('tanggal_berita', 'desc')
    // ->get();

    //     ->whereHas('kategoris', function ($q) {
    //     $q->where('nama_kategori', 'Prestasi');
    // })
    // ->orderBy('tanggal_berita', 'desc')
    // ->get();