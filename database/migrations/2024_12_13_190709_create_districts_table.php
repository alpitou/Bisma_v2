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
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('districts_id');
            $table->string('districts_code', 225)->unique();
            $table->string('cities_code', 225); // Foreign key relation can be defined in model
            $table->string('districts_name', 225);
            $table->timestamp('districts_created_at')->nullable();
            $table->string('districts_created_by', 225)->nullable();
            $table->timestamp('districts_updated_at')->nullable();
            $table->string('districts_updated_by', 225)->nullable();
            $table->timestamp('districts_deleted_at')->nullable();
            $table->string('districts_deleted_by', 225)->nullable();
            $table->text('districts_notes')->nullable();
            $table->string('districts_status', 225);
            $table->integer('districts_soft_delete')->default(0); // 1 for yes, 0 for no

            // Optional: If you want to enforce a foreign key constraint
            $table->foreign('cities_code')->references('cities_code')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
