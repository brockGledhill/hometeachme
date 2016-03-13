<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class ChangeWardCompanionshipMembersToCompanionshipFamilies
 */
class ChangeWardCompanionshipMembersToCompanionshipFamilies extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_companionship_members')) {
			Schema::rename('ward_companionship_members', 'companionship_families');
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('companionship_families')) {
			Schema::rename('companionship_families', 'ward_companionship_members');
		}
	}
}
