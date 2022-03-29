<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->foreignUuid('exercise_id')->constrained('exercises');
            $table->foreignUuid('muscle_id')->constrained('muscles');
            $table->enum('type', ['primary', 'secondary']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_muscle');
    }
};
