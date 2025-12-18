<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Komentar;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tanggapan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tanggapan';

    protected $fillable = [
        'komentar_id', 
        'admin_id',
        'isi',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function komentar()
    {
        return $this->belongsTo(Komentar::class, 'komentar_id');
    }
}
