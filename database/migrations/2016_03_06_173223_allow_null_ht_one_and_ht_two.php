<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullHtOneAndHtTwo extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('companionships')) {
			Schema::table('companionships', function (Blueprint $table) {
				$table->integer('ht_one_id')->unsigned()->nullable()->change();
				$table->integer('ht_two_id')->unsigned()->nullable()->change();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('companionships')) {
			Schema::table('companionships', function (Blueprint $table) {
				$table->integer('ht_one_id')->unsigned()->change();
				$table->integer('ht_two_id')->unsigned()->change();
			});
		}
	}
}
