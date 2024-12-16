<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'provinces_id';
    protected $table = 'provinces';

    public $timestamps = false;
    protected $fillable = [
        'provinces_code',
        'provinces_name',
        'provinces_created_at',
        'provinces_created_by',
        'provinces_updated_at',
        'provinces_updated_by',
        'provinces_deleted_at',
        'provinces_deleted_by',
        'provinces_notes',
        'provinces_status',
        'provinces_soft_delete',
    ];
}
