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
        Schema::create('tag_sprints', function (Blueprint $table) {
            $table->comment('For tag based sprints, not using Bitrix itself');
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable()->default(0)->comment('Key for tasks');
            $table->unsignedInteger('sprint_number')->nullable()->comment('Sprint Number. e.g. 50');
            $table->string('sprint_tag')->nullable()->comment('Sprint Tag. e.g. sp50');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_sprints');
    }
};
