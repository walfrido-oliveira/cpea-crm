<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToConversationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_items', function (Blueprint $table) {
            $table->foreignId('etapa_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('cnpj_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('ppi')->nullable();
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
            $table->dropColumn('etapa_id', 'cnpj_id', 'ppi');
        });
    }
}
