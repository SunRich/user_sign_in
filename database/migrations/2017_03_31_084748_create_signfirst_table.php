<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignfirstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signin_first', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->comment('the user id');
            $table->dateTime('first_time')->comment('first sign time');
            $table->index('first_time');
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signin_first');
    }
}
