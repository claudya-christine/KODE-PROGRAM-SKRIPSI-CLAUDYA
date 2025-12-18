<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'isi',
        'penulis',
        'tanggal_berita',
        'is_active',
    ];

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategori');
    }

    public function media()
    {
        return $this->hasMany(MediaBerita::class);
    }

        public function komentar() {
    return $this->hasMany(Komentar::class, 'berita_id');
}

}

