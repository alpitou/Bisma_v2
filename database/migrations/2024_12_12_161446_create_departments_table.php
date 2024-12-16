<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('department_id');
            $table->string('department_code', 225)->unique();
            $table->string('division_code', 225); // Relasi
            $table->string('department_name', 225);
            $table->timestamp('department_created_at')->nullable();
            $table->string('department_created_by', 225)->nullable();
            $table->timestamp('department_updated_at')->nullable();
            $table->string('department_updated_by', 225)->nullable();
            $table->timestamp('department_deleted_at')->nullable();
            $table->string('department_deleted_by', 225)->nullable();
            $table->text('department_notes')->nullable();
            $table->boolean('department_soft_delete')->default(0); // 1 for soft delete, 0 for not deleted
            $table->timestamps();

            
            $table->foreign('division_code')
                  ->references('division_code')
                  ->on('divisions')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
