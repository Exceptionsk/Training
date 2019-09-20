<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('lists', function(Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->text('descriptions');
          $table->datetime('action_time');
          $table->unsignedInteger('user_id');
          $table->foreign('user_id')
              ->references('id')->on('core_users')
              ->onDelete('restrict');

          //Common to all table ----------------------------------------------
          $table->string('created_by',100)->nullable();
          $table->string('updated_by',100)->nullable();
          $table->string('deleted_by',100)->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lists');
    }
}
