<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidingParameterValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guiding_parameter_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guiding_parameter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('analysis_matrix_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parameter_analysis_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guiding_parameter_ref_value_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('guiding_value_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('unity_legislation_id');
            $table->unsignedBigInteger('unity_analysis_id');

            $table->decimal('guiding_legislation_value', 18, 5);
            $table->decimal('guiding_legislation_value_1', 18, 5)->nullable();
            $table->decimal('guiding_legislation_value_2', 18, 5)->nullable();

            $table->decimal('guiding_analysis_value', 18, 5)->nullable();
            $table->decimal('guiding_analysis_value_1', 18, 5)->nullable();
            $table->decimal('guiding_analysis_value_2', 18, 5)->nullable();

            $table->timestamps();

            $table->foreign('unity_legislation_id')->references('id')->on('unities');
            $table->foreign('unity_analysis_id')->references('id')->on('unities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guiding_parameter_values');
    }
}
