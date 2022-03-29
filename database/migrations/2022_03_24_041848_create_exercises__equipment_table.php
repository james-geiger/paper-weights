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
        Schema::create('exercises__equipment', function (Blueprint $table) {
            $table->foreignUuid('exercise_id')->constrained('exercises');
            $table->foreignUuid('equipment_id')->constrained('equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises__equipment');
    }
};
