<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $primaryKey = 'shift_id'; // Primary key
    protected $table = 'shifts'; // Table name

    public $timestamps = false; // Disable default timestamps

    protected $fillable = [
        'shift_code',
        'companies_code',
        'shift_name',
        'shift_start_time_before_break',
        'shift_end_time_before_break',
        'shift_start_time_break',
        'shift_end_time_break',
        'shift_start_time_after_break',
        'shift_end_time_after_break',
        'shift_created_at',
        'shift_created_by',
        'shift_updated_at',
        'shift_updated_by',
        'shift_deleted_at',
        'shift_deleted_by',
        'shift_notes',
        'shift_soft_delete',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_code', 'code');
    }
}
