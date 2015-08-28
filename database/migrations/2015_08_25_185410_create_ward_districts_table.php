<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardDistrictsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ward_districts', function (Blueprint $table) {
			$table->increments('id');
			$table->smallInteger('quorum_id')->nullable();
			$table->bigInteger('ward_id');
			$table->bigInteger('member_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('ward_districts');
	}
}
