<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWardCompanionsToCompanionships extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_companions')) {
			Schema::rename('ward_companions', 'companionships');
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('companionships')) {
			Schema::rename('companionships', 'ward_companions');
		}
	}
}
