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
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('cities_id');
            $table->string('cities_code', 225)->unique();
            $table->string('provinces_code', 225); // Foreign key relation can be defined in model
            $table->string('cities_name', 225);
            $table->timestamp('cities_created_at')->nullable();
            $table->string('cities_created_by', 225)->nullable();
            $table->timestamp('cities_updated_at')->nullable();
            $table->string('cities_updated_by', 225)->nullable();
            $table->timestamp('cities_deleted_at')->nullable();
            $table->string('cities_deleted_by', 225)->nullable();
            $table->text('cities_notes')->nullable();
            $table->string('cities_status', 225);
            $table->integer('cities_soft_delete')->default(0); // 1 for yes, 0 for no

            // Optional: If you want to enforce a foreign key constraint
            $table->foreign('provinces_code')->references('provinces_code')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
