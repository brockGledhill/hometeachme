<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardCompanionshipVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_companionship_visits', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';

            $table->increments('id');
			$table->bigInteger('comp_id');
			$table->bigInteger('member_id');
			$table->string('visit_year');
			$table->string('visit_month');
			$table->bigInteger('ward_id');
			$table->bigInteger('quorum_id');
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
        Schema::drop('ward_companionship_visits');
    }
}
