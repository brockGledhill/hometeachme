<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardCompanionshipMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_companionship_members', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';

            $table->increments('id');
			$table->bigInteger('companionship_id');
			$table->bigInteger('member_id');
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
        Schema::drop('ward_companionship_members');
    }
}
