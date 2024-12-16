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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('companies_id');
            $table->string('companies_code', 225)->unique(); 
            $table->string('companies_name', 225);
            $table->timestamp('companies_created_at')->nullable();
            $table->string('companies_created_by', 225)->nullable();
            $table->timestamp('companies_updated_at')->nullable();
            $table->string('companies_updated_by', 225)->nullable();
            $table->timestamp('companies_deleted_at')->nullable();
            $table->string('companies_deleted_by', 225)->nullable();
            $table->text('companies_notes')->nullable();
            $table->boolean('companies_soft_delete')->default(0); // 1 for yes, 0 for no
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
