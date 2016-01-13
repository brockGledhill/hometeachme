<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_companions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';

            $table->increments('id');
			$table->bigInteger('ht_one_id');
			$table->bigInteger('ht_two_id');
			$table->bigInteger('ward_id');
			$table->bigInteger('district_id');
			$table->bigInteger('quorum_id');
			$table->bigInteger('family_id')->nullable();
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
        Schema::drop('ward_companions');
    }
}
