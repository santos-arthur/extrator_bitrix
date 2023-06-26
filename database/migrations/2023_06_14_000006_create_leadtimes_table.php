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
        Schema::create('leadtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable()->default(0)->comment('Key for tasks');
            $table->unsignedBigInteger('stage_id')->nullable()->default(0)->comment('Key for stages');
            $table->dateTimeTz('entered_at')->nullable();
            $table->dateTimeTz('left_at')->nullable();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('set default');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('set default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadtimes');
    }
};
