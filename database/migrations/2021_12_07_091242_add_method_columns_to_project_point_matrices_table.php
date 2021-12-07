<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMethodColumnsToProjectPointMatricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_point_matrices', function (Blueprint $table) {
            $table->unsignedBigInteger('parameter_method_preparation_id')->nullable()->after('parameter_analysis_id');
            $table->unsignedBigInteger('parameter_method_analysis_id')->nullable()->after('parameter_method_preparation_id');

            $table->foreign('parameter_method_preparation_id', 'project_point_matrices_parameter_method_preparation_id')->references('id')->on('parameter_methods');
            $table->foreign('parameter_method_analysis_id', 'project_point_matrices_parameter_method_analysis_id')->references('id')->on('parameter_methods');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_point_matrices', function (Blueprint $table) {
            $table->dropForeign('project_point_matrices_parameter_method_preparation_id');
            $table->dropForeign('project_point_matrices_parameter_method_analysis_id');
            $table->dropColumn('parameter_method_preparation_id', 'parameter_method_analysis_id');
        });
    }
}
