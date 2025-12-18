<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaBerita extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'media_berita';

    protected $fillable = [
        'berita_id',
        'file_path',
        'tipe',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}
