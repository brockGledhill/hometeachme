<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class ChangeWardCompanionshipVisitsToCompanionshipVisits
 */
class ChangeWardCompanionshipVisitsToCompanionshipVisits extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_companionship_visits')) {
			Schema::rename('ward_companionship_visits', 'companionship_visits');
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('companionship_visits')) {
			Schema::rename('companionship_visits', 'ward_companionship_visits');
		}
	}
}
