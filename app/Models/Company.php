<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    protected $primaryKey = 'companies_id';
    protected $table = 'companies';

    public $timestamps = false;
    protected $fillable = [
        'companies_code',
        'companies_name',
        'companies_created_at',
        'companies_created_by',
        'companies_updated_at',
        'companies_updated_by',
        'companies_deleted_at',
        'companies_deleted_by',
        'companies_notes',
        'companies_soft_delete',
    ];
}
