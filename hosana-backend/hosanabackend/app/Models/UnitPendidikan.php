<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPendidikan extends Model
{
    use HasFactory;

    protected $table = 'unit_pendidikan';

    protected $fillable = ['pendidikan'];
}
