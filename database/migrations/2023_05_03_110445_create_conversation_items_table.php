<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_items', function (Blueprint $table) {
            $table->id();
            $table->string("item_type")->index();
            $table->timestamp('interaction_at')->nullable();
            $table->boolean('additive');
            $table->string("cpea_linked_id")->nullable()->index();
            $table->text("item_details")->nullable();

            $table->string("schedule_type")->nullable();
            $table->string("schedule_name")->nullable();
            $table->timestamp('schedule_at')->nullable();
            $table->string("addressees")->nullable();
            $table->string("optional_addressees")->nullable();
            $table->text("schedule_details")->nullable();

            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('proposed_status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('prospecting_status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('detailed_contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::dropIfExists('conversation_items');
    }
}
