<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_methods', function (Blueprint $table) {
            $table->id();
            #$table->foreignId('analysis_matrix_id')->constrained()->cascadeOnDelete();
            #$table->foreignId('parameter_analysis_id')->constrained()->cascadeOnDelete();

            $table->foreignId('preparation_method_id')->constrained()->cascadeOnDelete();

            #$table->foreignId('analysis_method_id')->constrained()->cascadeOnDelete();

            $table->boolean("validate_preparation");
            $table->integer("time_preparation");
            $table->string('type');
            #$table->integer("time_analysis");

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
        Schema::dropIfExists('parameter_methods');
    }
}
