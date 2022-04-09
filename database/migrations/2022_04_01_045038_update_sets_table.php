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
        Schema::table('sets', function (Blueprint $table) {
            $table->after('order', function ($table) {
                $table->integer('sets');
            });
        });

        Schema::table('sets', function (Blueprint $table) {
            $table->after('weight', function ($table) {
                $table->decimal('weight_added', 16, 2)->nullable();
                $table->decimal('weight_assisted', 16, 2)->nullable();
                $table->decimal('duration', 16, 2)->nullable();
                $table->decimal('distance', 16, 2)->nullable();
                $table->foreignUuid('unit_id')->nullable()->constrained();
            });
        });

        Schema::table('sets', function (Blueprint $table) {
            $table->decimal('reps', 16, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
