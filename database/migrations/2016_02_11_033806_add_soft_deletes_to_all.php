<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToAll extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('districts')) {
			Schema::table('districts', function ($table) {
				$table->softDeletes();
			});
		}

		if (Schema::hasTable('ward_companions')) {
			Schema::table('ward_companions', function ($table) {
				$table->softDeletes();
			});
		}

		if (Schema::hasTable('ward_companionship_members')) {
			Schema::table('ward_companionship_members', function ($table) {
				$table->softDeletes();
			});
		}

		if (Schema::hasTable('ward_members')) {
			Schema::table('ward_members', function ($table) {
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
		if (Schema::hasTable('districts') && Schema::hasColumn('districts', 'deleted_at')) {
			Schema::table('districts', function ($table) {
				$table->dropColumn('deleted_at');
			});
		}

		if (Schema::hasTable('ward_companions') && Schema::hasColumn('ward_companions', 'deleted_at')) {
			Schema::table('ward_companions', function ($table) {
				$table->dropColumn('deleted_at');
			});
		}

		if (Schema::hasTable('ward_companionship_members') && Schema::hasColumn('ward_companionship_members', 'deleted_at')) {
			Schema::table('ward_companionship_members', function ($table) {
				$table->dropColumn('deleted_at');
			});
		}

		if (Schema::hasTable('ward_members') && Schema::hasColumn('ward_members', 'deleted_at')) {
			Schema::table('ward_members', function ($table) {
				$table->dropColumn('deleted_at');
			});
		}
	}
}
