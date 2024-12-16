<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApproval extends Model
{
    use HasFactory;

    protected $primaryKey = 'master_approvals_id'; // Primary key
    protected $table = 'master_approvals'; 

    public $timestamps = false; 

    protected $fillable = [
        'master_approvals_code',
        'master_approvals_name',
        'department_code',
        'division_code',
        'level_code',
        'master_approvals_created_at',
        'master_approvals_created_by',
        'master_approvals_updated_at',
        'master_approvals_updated_by',
        'master_approvals_deleted_at',
        'master_approvals_deleted_by',
        'master_approvals_notes',
        'master_approvals_soft_delete',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_code', 'departments_code');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_code', 'division_code');
    }

    public function level()
    {
        return $this->belongsTo(Levels::class, 'level_code', 'level_code');
    }
}
