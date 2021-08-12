<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterAnalysisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analysis_parameter_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('parameter_analysis_group_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('cas_rn')->nullable();
            $table->string('ref_cas_rn')->nullable();
            $table->string('analysis_parameter_name');
            $table->integer('order')->nullable();
            $table->decimal('decimal_place', 18, 5)->nullable();
            $table->dateTime('final_validity')->nullable();

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
        Schema::dropIfExists('parameter_analyses');
    }
}
