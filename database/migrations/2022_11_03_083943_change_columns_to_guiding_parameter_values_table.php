<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsToGuidingParameterValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guiding_parameter_values', function (Blueprint $table) {
            $table->string('guiding_legislation_value')->change();
            $table->string('guiding_legislation_value_1')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guiding_parameter_values', function (Blueprint $table) {
            //
        });
    }
}
