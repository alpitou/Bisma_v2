<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    public $timestamps = false;
    protected $primaryKey = 'department_id';
    protected $fillable = [
        'department_code',
        'division_code',
        'department_name',
        'department_created_at',
        'department_created_by',
        'department_updated_at',
        'department_updated_by',
        'department_deleted_at',
        'department_deleted_by',
        'department_notes',
        'department_soft_delete'
    ];
    public function division()
    {
        return $this->belongsTo(Company::class, 'division_code', 'division_code');
    }
}
