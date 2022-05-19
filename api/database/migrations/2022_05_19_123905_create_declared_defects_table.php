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
        Schema::create('declared_defects', function (Blueprint $table) {
            $table->id();
            $table->integer('defect_id');
            $table->string('finit');
            $table->string('part_number');
            $table->string('line');
            $table->string('defect_code');
            $table->string('identified_station');
            $table->string('produced_station');
            $table->integer('quantity');
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declared_defects');
    }
};
