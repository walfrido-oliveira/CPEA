<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidingParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guiding_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environmental_area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('environmental_agency_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->constrained();

            $table->string('environmental_guiding_parameter_id');
            $table->string('name');

            $table->string('resolutions')->nullable();
            $table->string('articles')->nullable();
            $table->string('observation')->nullable();

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
        Schema::dropIfExists('guiding_parameters');
    }
}
