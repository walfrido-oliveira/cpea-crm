<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns2ToConversationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_items', function (Blueprint $table) {
            $table->foreignId('conversation_status_id')->nullable()->constrained()->cascadeOnDelete();
            //$table->dropForeign('project_status_id', 'proposed_status_id', 'prospecting_status_id');
            //$table->dropColumn('project_status_id', 'proposed_status_id', 'prospecting_status_id');

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
            $table->dropForeign('conversation_status_id');
            $table->dropColumn('conversation_status_id');
        });
    }
}
