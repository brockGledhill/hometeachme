<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArchivedToWardComments extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_comments')) {
			Schema::table('ward_comments', function ($table) {
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
		if (Schema::hasTable('ward_comments') && Schema::hasColumn('ward_comments', 'deleted_at')) {
			Schema::table('ward_comments', function ($table) {
				$table->dropColumn('deleted_at');
			});
		}
	}
}
