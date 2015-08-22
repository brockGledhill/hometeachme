<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ward_members', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';

			$table->increments('id');
			$table->string('email', 255);
			$table->string('password', 255);
			$table->string('first_name', 255);
			$table->string('last_name', 255);
			$table->boolean('is_assigned')->default(false);
			$table->smallInteger('quorum_id')->nullable();
			$table->bigInteger('ward_id');
			$table->boolean('is_admin')->default(false);
			$table->string('phone', 255)->nullable();
			$table->string('spouse_name', 255)->nullable();
			$table->boolean('is_jr_comp')->default(true);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('ward_members');
	}
}