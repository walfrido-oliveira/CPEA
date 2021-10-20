<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPointMatrixGuidingParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guiding_parameter_project_point_matrix', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_point_matrix_id');
            $table->unsignedBigInteger('guiding_parameter_id');

            $table->foreign('project_point_matrix_id', 'ppmgp_point_matrix_id_foreign')->references('id')->on('project_point_matrices');
            $table->foreign('guiding_parameter_id', 'ppmgp_guiding_parameter_id_foreign')->references('id')->on('guiding_parameters');

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
        Schema::dropIfExists('project_point_matrix_guiding_parameter');
    }
}
