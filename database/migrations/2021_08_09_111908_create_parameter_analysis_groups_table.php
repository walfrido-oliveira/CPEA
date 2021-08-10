<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterAnalysisGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_analysis_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_analysis_group_id')->nullable()->constrained()->onDelete('set null');

            $table->string("name");
            $table->string("order");
            $table->timestamp("final_validity");
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
        Schema::dropIfExists('parameter_analysis_groups');
    }
}
