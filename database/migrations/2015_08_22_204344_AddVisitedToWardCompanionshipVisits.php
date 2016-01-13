<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitedToWardCompanionshipVisits extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_companionship_visits')) {
			Schema::table('ward_companionship_visits', function($table) {
				$table->softDeletes();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('ward_companionship_visits') && Schema::hasColumn('ward_companionship_visits', 'deleted_at')) {
			Schema::table('ward_companionship_visits', function($table) {
				$table->dropColumn('deleted_at');
			});
		}
	}
}
