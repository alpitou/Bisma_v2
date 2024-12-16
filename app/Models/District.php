<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';
    public $timestamps = false;
    protected $primaryKey = 'districts_id';
    protected $fillable = [
        'districts_code',
        'cities_code',
        'districts_name',
        'districts_created_at',
        'districts_created_by',
        'districts_updated_at',
        'districts_updated_by',
        'districts_deleted_at',
        'districts_deleted_by',
        'districts_notes',
        'districts_status',
        'districts_soft_delete'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_code', 'cities_code');
    }
}
