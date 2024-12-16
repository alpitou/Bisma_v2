<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homebase extends Model
{
    use HasFactory;

    protected $primaryKey = 'homebase_id'; // Primary key
    protected $table = 'homebases'; 

    public $timestamps = false; 

    protected $fillable = [
        'homebase_code',
        'companies_code',
        'homebase_name',
        'homebase_created_at',
        'homebase_created_by',
        'homebase_updated_at',
        'homebase_updated_by',
        'homebase_deleted_at',
        'homebase_deleted_by',
        'homebase_notes',
        'homebase_soft_delete',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_code', 'companies_code');
    }
}
