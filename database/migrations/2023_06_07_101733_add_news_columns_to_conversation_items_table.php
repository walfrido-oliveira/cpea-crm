<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewsColumnsToConversationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_items', function (Blueprint $table) {
            $table->string('teams_id')->nullable();
            $table->string('teams_token')->nullable();
            $table->timestamp('schedule_end')->nullable();
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
            $table->dropColumn('teams_id', 'teams_token', 'schedule_end');
        });
    }
}
