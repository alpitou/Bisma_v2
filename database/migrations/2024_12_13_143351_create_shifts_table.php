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
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('shift_id');
            $table->string('shift_code', 225)->unique();
            $table->string('companies_code', 225); // Foreign key to company table
            $table->string('shift_name', 225);
            $table->time('shift_start_time_before_break');
            $table->time('shift_end_time_before_break');
            $table->time('shift_start_time_break');
            $table->time('shift_end_time_break');
            $table->time('shift_start_time_after_break');
            $table->time('shift_end_time_after_break');
            $table->timestamp('shift_created_at')->useCurrent();
            $table->string('shift_created_by', 225);
            $table->timestamp('shift_updated_at')->nullable()->useCurrentOnUpdate();
            $table->string('shift_updated_by', 225)->nullable();
            $table->timestamp('shift_deleted_at')->nullable();
            $table->string('shift_deleted_by', 225)->nullable();
            $table->text('shift_notes')->nullable();
            $table->boolean('shift_soft_delete')->default(0); // 1 for yes, 0 for no

            // Indexes and relations
            $table->foreign('companies_code')->references('companies_code')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
