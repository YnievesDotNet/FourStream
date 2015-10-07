<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFstagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fstags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag')->nullable();
            $table->integer('fsnode_id')->unsigned();
            $table->foreign('fsnode_id')->references('id')->on('fsnodes')->onDelete('cascade');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('fstags');
    }
}
