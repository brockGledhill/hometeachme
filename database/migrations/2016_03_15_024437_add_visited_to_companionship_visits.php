<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddVisitedToCompanionshipVisits
 */
class AddVisitedToCompanionshipVisits extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('companionship_visits', function (Blueprint $table) {
			$table->enum('visited', ['yes', 'no'])->after('visit_month')->default('yes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('companionship_visits', function (Blueprint $table) {
			$table->dropColumn('visited');
		});
	}
}
