<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_point_matrix_id');
            $table->foreignId('analysis_order_id')->constrained()->onDelete('cascade');

            $table->string('client')->nullable();
            $table->string('project')->nullable();
            $table->string('projectnum')->nullable();
            $table->string('labname')->nullable();
            $table->string('samplename')->nullable();
            $table->string('labsampid')->nullable();
            $table->string('matrix')->nullable();
            $table->string('rptmatrix')->nullable();
            $table->string('solidmatrix')->nullable();
            $table->string('sampdate')->nullable();
            $table->string('prepdate')->nullable();
            $table->string('anadate')->nullable();
            $table->string('batch')->nullable();
            $table->string('analysis')->nullable();
            $table->string('anacode')->nullable();
            $table->string('methodcode')->nullable();
            $table->string('methodname')->nullable();
            $table->string('description')->nullable();
            $table->string('prepname')->nullable();
            $table->string('analyte')->nullable();
            $table->string('analyteorder')->nullable();
            $table->string('casnumber')->nullable();
            $table->string('surrogate')->nullable();
            $table->string('tic')->nullable();
            $table->string('result')->nullable();
            $table->string('dl')->nullable();
            $table->string('rl')->nullable();
            $table->string('units')->nullable();
            $table->string('rptomdl')->nullable();
            $table->string('mrlsolids')->nullable();
            $table->string('basis')->nullable();
            $table->string('dilution')->nullable();
            $table->string('spikelevel')->nullable();
            $table->string('recovery')->nullable();
            $table->string('uppercl')->nullable();
            $table->string('lowercl')->nullable();
            $table->string('analyst')->nullable();
            $table->string('psolids')->nullable();
            $table->string('lnote')->nullable();
            $table->string('anote')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('scomment')->nullable();
            $table->string('snote1')->nullable();
            $table->string('snote2')->nullable();
            $table->string('snote3')->nullable();
            $table->string('snote4')->nullable();
            $table->string('snote5')->nullable();
            $table->string('snote6')->nullable();
            $table->string('snote7')->nullable();
            $table->string('snote8')->nullable();
            $table->string('snote9')->nullable();
            $table->string('snote10')->nullable();


            $table->timestamps();

            $table->foreign('project_point_matrix_id', 'project_point_matrix_id_foreign')->references('id')->on('project_point_matrices')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analysis_results');
    }
}
