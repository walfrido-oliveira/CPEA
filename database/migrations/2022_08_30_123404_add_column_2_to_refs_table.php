<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumn2ToRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('field');
            $table->foreignId('field_type_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refs', function (Blueprint $table) {
            $table->dropColumn('field_type_id');
        });
    }
}
