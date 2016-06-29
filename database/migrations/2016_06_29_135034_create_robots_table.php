<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robots', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('shop_id')->unsigned()->index();

            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->string('heading',1)->nullable();
            $table->text('commands')->nullable();
            //$table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('robots');
    }
}
