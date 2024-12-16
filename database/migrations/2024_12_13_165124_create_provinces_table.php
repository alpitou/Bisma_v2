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
        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('provinces_id');
            $table->string('provinces_code', 225)->unique();
            $table->string('provinces_name', 225);
            $table->timestamp('provinces_created_at')->nullable();
            $table->string('provinces_created_by', 225)->nullable();
            $table->timestamp('provinces_updated_at')->nullable();
            $table->string('provinces_updated_by', 225)->nullable();
            $table->timestamp('provinces_deleted_at')->nullable();
            $table->string('provinces_deleted_by', 225)->nullable();
            $table->text('provinces_notes')->nullable();
            $table->string('provinces_status', 225)->nullable();
            $table->tinyInteger('provinces_soft_delete')->default(0); // 1: yes, 0: no
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};