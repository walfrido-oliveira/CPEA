<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_identifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('geodetic_system_id')->constrained()->onDelete('cascade')->nullable();

            $table->string("area");
            $table->string("identification");

            $table->decimal("utm_me_coordinate", 18, 5)->nullable();
            $table->decimal("utm_mm_coordinate", 18, 5)->nullable();

            $table->decimal("pool_depth", 18, 5)->nullable();
            $table->decimal("pool_diameter", 18, 5)->nullable();
            $table->decimal("pool_volume", 18, 5)->nullable();

            $table->decimal("water_depth", 18, 5)->nullable();
            $table->decimal("water_collection_depth", 18, 5)->nullable();

            $table->decimal("sedimentary_collection_depth", 18, 5)->nullable();
            $table->decimal("collection_depth", 18, 5)->nullable();

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
        Schema::dropIfExists('point_identifications');
    }
}
