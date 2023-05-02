<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailedContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailed_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact');
            $table->string('mail')->nullable();
            $table->string('phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('role')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('secretary')->nullable();
            $table->string('mail_secretary')->nullable();
            $table->string('phone_secretary')->nullable();
            $table->string('cell_phone_secretary')->nullable();
            $table->text('obs')->nullable();

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('detailed_contacts');
    }
}
