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
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('division_id');
            $table->string('division_code', 225)->unique();
            $table->string('companies_code', 225); // Relasi dengan company
            $table->string('division_name', 225);
            $table->timestamp('division_created_at')->nullable();
            $table->string('division_created_by', 225)->nullable();
            $table->timestamp('division_updated_at')->nullable();
            $table->string('division_updated_by', 225)->nullable();
            $table->timestamp('division_deleted_at')->nullable();
            $table->string('division_deleted_by', 225)->nullable();
            $table->text('division_notes')->nullable();
            $table->boolean('division_soft_delete')->default(0); // Soft delete: 1 = yes, 0 = no
            
            $table->foreign('companies_code')
                  ->references('companies_code')
                  ->on('companies')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};