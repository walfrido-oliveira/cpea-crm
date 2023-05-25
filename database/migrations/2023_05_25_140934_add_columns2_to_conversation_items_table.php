<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns2ToConversationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_items', function (Blueprint $table) {
            $table->string('meeting_form')->nullable()->index();
            $table->string('meeting_place')->nullable();
            $table->text('teams_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversation_items', function (Blueprint $table) {
            //
        });
    }
}
