<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'divisions';

    // Primary key
    protected $primaryKey = 'division_id';

    // Atribut yang dapat diisi
    protected $fillable = [
        'division_code',
        'companies_code',
        'division_name',
        'division_created_at',
        'division_created_by',
        'division_updated_at',
        'division_updated_by',
        'division_deleted_at',
        'division_deleted_by',
        'division_notes',
        'division_soft_delete',
    ];

    // Timestamps bawaan Laravel
    public $timestamps = false;

    /**
     * Relasi ke model Company
     * Asumsikan Anda memiliki model Company dengan companies_code sebagai unique identifier.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_code', 'companies_code');
    }
}
