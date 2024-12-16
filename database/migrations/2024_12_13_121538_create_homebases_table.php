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
        Schema::create('homebases', function (Blueprint $table) {
            $table->bigIncrements('homebase_id');
            $table->string('homebase_code', 225)->unique();
            $table->string('companies_code', 225); // Foreign key reference to companies table
            $table->string('homebase_name', 225);
            $table->timestamp('homebase_created_at')->nullable();
            $table->string('homebase_created_by', 225)->nullable();
            $table->timestamp('homebase_updated_at')->nullable();
            $table->string('homebase_updated_by', 225)->nullable();
            $table->timestamp('homebase_deleted_at')->nullable();
            $table->string('homebase_deleted_by', 225)->nullable();
            $table->text('homebase_notes')->nullable();
            $table->integer('homebase_soft_delete')->default(0); // 1 for yes, 0 for no

            // Foreign key constraint
            $table->foreign('companies_code')->references('companies_code')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homebases');
    }
};
