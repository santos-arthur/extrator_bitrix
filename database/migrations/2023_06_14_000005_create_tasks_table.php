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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->comment('Parent Task ID')->nullable()->default(0);
            $table->string('title')->nullable();
            $table->unsignedBigInteger('group_id')->comment('Key for groups')->nullable()->default(0);
            $table->unsignedBigInteger('stage_id')->comment('Key for stages')->nullable()->default(0);
            $table->unsignedBigInteger('status_id')->comment('Key for status')->nullable()->default(0);
            $table->unsignedBigInteger('created_by')->comment('Key for users')->nullable()->default(0);
            $table->dateTimeTz('created_date')->nullable();
            $table->unsignedBigInteger('responsible_id')->comment('Key for users')->nullable()->default(0);
            $table->unsignedBigInteger('closed_by')->comment('Key for users')->nullable()->default(0);
            $table->dateTimeTz('closed_date')->nullable();
            $table->bigInteger('time_estimate')->comment('In seconds')->nullable();
            $table->bigInteger('time_spent')->comment('In seconds')->nullable();
            $table->string('auditors')->comment('Users separated by semicolon')->nullable();
            $table->string('accomplices')->comment('Users separated by semicolon')->nullable();
            $table->string('tags')->comment('Tags separated by semicolon')->nullable();
            $table->boolean('import_leadtimes')->comment('Does this task imports the leadtimes into routine?')->default(1);

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set default');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('set default');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('set default');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set default');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('set default');
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('set default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
