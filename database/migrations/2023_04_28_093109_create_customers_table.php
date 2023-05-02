<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->char("cnpj", 14)->index();
            $table->string("corporate_name");
            $table->text("obs")->nullable();
            $table->text("competitors")->nullable();
            $table->string("status")->default("active");

            $table->foreignId('sector_id')->constrained()->cascadeOnDelete();
            $table->foreignId('segment_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('created_user');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('updated_user')->nullable();
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('customers');
    }
}
