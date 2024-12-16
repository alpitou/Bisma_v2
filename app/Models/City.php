<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    public $timestamps = false;
    protected $primaryKey = 'cities_id';
    protected $fillable = [
        'cities_code',
        'provinces_code',
        'cities_name',
        'cities_created_at',
        'cities_created_by',
        'cities_updated_at',
        'cities_updated_by',
        'cities_deleted_at',
        'cities_deleted_by',
        'cities_notes',
        'cities_status',
        'cities_soft_delete'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinces_code', 'provinces_code');
    }
}