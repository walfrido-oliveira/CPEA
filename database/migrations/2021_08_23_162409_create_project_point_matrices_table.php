<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPointMatricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_point_matrices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('point_identification_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('analysis_matrix_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('plan_action_level_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('guiding_parameter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parameter_analysis_id')->nullable()->constrained()->nullOnDelete();

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
        Schema::dropIfExists('project_point_matrices');
    }
}
