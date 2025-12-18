<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UnitPendidikan;

class GuruStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gurustaff';
    protected $primaryKey = 'staffID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'staffID',
        'namalengkap',
        'tanggal_lahir',
        'posisi',
        'unit_id',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function unit()
{
    return $this->belongsTo(UnitPendidikan::class, 'unit_id');
}
}
