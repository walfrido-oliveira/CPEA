<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAcceptanceIntervalToParameterAnalysisGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parameter_analysis_groups', function (Blueprint $table) {
            $table->decimal('acceptance_interval', 18, 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameter_analysis_groups', function (Blueprint $table) {
            $table->dropColumn('acceptance_interval');
        });
    }
}
