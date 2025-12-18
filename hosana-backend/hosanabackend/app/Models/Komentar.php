<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tanggapan;

class Komentar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'komentars';

    protected $fillable = [
        'berita_id',
        'user_id',
        'isi_komentar',
        'status',

    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'komentar_id');
    }

    protected static function booted()
{
    static::deleting(function ($komentar) {
        if (! $komentar->isForceDeleting()) {
            $komentar->tanggapan()->delete();
        }
    });

    static::restoring(function ($komentar) {
        $komentar->tanggapan()->withTrashed()->restore();
    });
}
}
