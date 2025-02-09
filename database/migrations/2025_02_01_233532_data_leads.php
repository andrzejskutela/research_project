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
        Schema::create('data_group_runs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->tinyInteger('leg');
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('data_leads', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->tinyInteger('leg');
            $table->foreignId('data_group_run_id')->nullable()->references('id')->on('data_group_runs')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->boolean('is_new_browser');
            $table->string('ip');
            $table->string('user_agent', length: 1000);
            $table->string('country')->nullable();
            $table->json('ip_info')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('meditation_exp')->nullable();
            $table->tinyInteger('exercise_exp')->nullable();
            $table->tinyInteger('coffee_exp')->nullable();
            $table->boolean('completed');
            $table->timestamps();
        });

        Schema::create('data_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_lead_id')->references('id')->on('data_leads')->onDelete('cascade');
            $table->tinyInteger('dataset_uid');
            $table->smallInteger('score');
            $table->decimal('time_seconds', total: 6, places: 2);
            $table->json('time_breakdown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_measurements');
        Schema::dropIfExists('data_leads');
        Schema::dropIfExists('data_group_runs');
    }
};
