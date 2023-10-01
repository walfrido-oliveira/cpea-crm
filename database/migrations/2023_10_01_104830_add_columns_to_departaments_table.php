<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDepartamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('acronym');
            $table->foreignId('direction_id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('directions', function (Blueprint $table) {
            $table->string('acronym');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('acronym', 'direction_id');
        });

        Schema::table('directions', function (Blueprint $table) {
            $table->dropColumn('acronym');
        });
    }
}
