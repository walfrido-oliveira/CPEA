<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisOrderProjectPointMatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_order_project_point_matrix', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_point_matrix_id');
            $table->unsignedBigInteger('analysis_order_id');

            $table->foreign('project_point_matrix_id', 'analysis_order_point_matrix_id_foreign')->references('id')->on('project_point_matrices');
            $table->foreign('analysis_order_id', 'order_point_matrix_analysis_id_foreign')->references('id')->on('analysis_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analysis_order_parameter_analysis');
    }
}
