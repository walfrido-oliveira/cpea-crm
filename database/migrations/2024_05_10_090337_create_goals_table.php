<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('goals', function (Blueprint $table) {
      $table->id();
      $table->foreignId('direction_id')->constrained()->cascadeOnDelete();
      $table->foreignId('department_id')->constrained()->cascadeOnDelete();
      $table->integer("year")->index();
      $table->integer("month")->index();
      $table->decimal("value", 10, 2);
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
    Schema::dropIfExists('goals');
  }
}
