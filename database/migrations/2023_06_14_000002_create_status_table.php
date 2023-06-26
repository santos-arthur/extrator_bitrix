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
        Schema::create('status', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('description');
            $table->boolean('open')->comment('Is task open?');
        });

        DB::table('status')->insert([
            [
                'id' => 0,
                'description' => 'Não identificado',
                'open' => false
            ],
            [
                'id' => 1,
                'description' => 'new',
                'open' => true
            ],
            [
                'id' => 2,
                'description' => 'pending',
                'open' => true
            ],
            [
                'id' => 3,
                'description' => 'in_progress',
                'open' => true
            ],
            [
                'id' => 4,
                'description' => 'supposedly_completed',
                'open' => true
            ],
            [
                'id' => 5,
                'description' => 'completed',
                'open' => false
            ],
            [
                'id' => 6,
                'description' => 'deferred',
                'open' => true
            ],
            [
                'id' => 7,
                'description' => 'declined',
                'open' => true
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
