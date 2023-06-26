<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title');
            $table->integer('sort')->nullable()->comment('Columns order');
            $table->string('color')->nullable()->comment('Color in RGB format');
            $table->unsignedBigInteger('group_id')->nullable()->comment('Key for groups')->default(0);
            $table->boolean('default')->comment('Is the default column')->default(0);

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set default');
        });

        DB::table('stages')->insert([
            'id' => 0,
            'title' => 'Não identificado',
            'sort' => null,
            'color' => null,
            'group_id' => 0,
            'default' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
