<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('project_point_matrix_id')->constrained();
            $table->foreignId('campaign_status_id')->constrained();

            $table->string('name');
            $table->timestamp('date_collection');

            $table->string('tide')->nullable();
            $table->string('environmental_conditions')->nullable();
            $table->string("sample_depth")->nullable();
            $table->string("environmental_regime")->nullable();
            $table->string("floating_materials")->nullable();
            $table->string("effluent_type")->nullable();
            $table->string("report_identification")->nullable();
            $table->string("organism_type")->nullable();
            $table->string("popular_name")->nullable();
            $table->string("identification_pm")->nullable();
            $table->string("sample_horizon")->nullable();
            $table->string('refq')->nullable();
            $table->string('utm')->nullable();
            $table->string("sedimentary_layer")->nullable();

            $table->decimal("water_depth", 18, 5)->nullable();
            $table->decimal("secchi_record", 18, 5)->nullable();
            $table->decimal("total_depth", 18, 5)->nullable();
            $table->decimal("sampling_area", 18, 5)->nullable();
            $table->decimal("pm_depth", 18, 5)->nullable();
            $table->decimal("pm_diameter", 18, 5)->nullable();
            $table->decimal("water_level", 18, 5)->nullable();
            $table->decimal("oil_level", 18, 5)->nullable();
            $table->decimal("field_measurements", 18, 5)->nullable();
            $table->decimal("temperature", 18, 5)->nullable();
            $table->decimal("humidity", 18, 5)->nullable();
            $table->decimal("pressure", 18, 5)->nullable();


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
        Schema::dropIfExists('campaigns');
    }
}
