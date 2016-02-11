<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnifyIntColumns extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('comments')) {
			Schema::table('comments', function($table) {
				$table->integer('family_id')->unsigned()->change();
				$table->integer('member_id')->unsigned()->change();
				$table->integer('companion_id')->unsigned()->change();
				$table->integer('ward_id')->unsigned()->change();
			});
		}

		if (Schema::hasTable('districts')) {
			Schema::table('districts', function($table) {
				$table->integer('quorum_id')->unsigned()->change();
				$table->integer('member_id')->unsigned()->change();
				$table->integer('ward_id')->unsigned()->change();
			});
		}

		if (Schema::hasTable('ward_companions')) {
			Schema::table('ward_companions', function($table) {
				$table->integer('ht_one_id')->unsigned()->change();
				$table->integer('ht_two_id')->unsigned()->change();
				$table->integer('ward_id')->unsigned()->change();
				$table->integer('district_id')->unsigned()->change();
				$table->integer('quorum_id')->unsigned()->change();
				$table->integer('family_id')->unsigned()->change();
			});
		}

		if (Schema::hasTable('ward_companionship_members')) {
			Schema::table('ward_companionship_members', function($table) {
				$table->integer('companionship_id')->unsigned()->change();
			});
		}

		if (Schema::hasTable('ward_companionship_visits')) {
			Schema::table('ward_companionship_visits', function($table) {
				$table->integer('comp_id')->unsigned()->change();
				$table->integer('member_id')->unsigned()->change();
				$table->integer('ward_id')->unsigned()->change();
				$table->integer('quorum_id')->unsigned()->change();
			});
		}

		if (Schema::hasTable('ward_members')) {
			Schema::table('ward_members', function($table) {
				$table->integer('ward_id')->unsigned()->change();
				$table->integer('quorum_id')->unsigned()->change();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('comments')) {
			Schema::table('comments', function($table) {
				$table->bigInteger('family_id')->change();
				$table->bigInteger('member_id')->change();
				$table->bigInteger('companion_id')->change();
				$table->bigInteger('ward_id')->change();
			});
		}

		if (Schema::hasTable('districts')) {
			Schema::table('districts', function($table) {
				$table->smallInteger('quorum_id')->change();
				$table->bigInteger('member_id')->change();
				$table->bigInteger('ward_id')->change();
			});
		}

		if (Schema::hasTable('ward_companions')) {
			Schema::table('ward_companions', function($table) {
				$table->bigInteger('ht_one_id')->change();
				$table->bigInteger('ht_two_id')->change();
				$table->bigInteger('ward_id')->change();
				$table->bigInteger('district_id')->change();
				$table->bigInteger('quorum_id')->change();
				$table->bigInteger('family_id')->change();
			});
		}

		if (Schema::hasTable('ward_companionship_members')) {
			Schema::table('ward_companionship_members', function($table) {
				$table->bigInteger('companionship_id')->change();
			});
		}

		if (Schema::hasTable('ward_companionship_visits')) {
			Schema::table('ward_companionship_visits', function($table) {
				$table->bigInteger('comp_id')->change();
				$table->bigInteger('member_id')->change();
				$table->bigInteger('ward_id')->change();
				$table->bigInteger('quorum_id')->change();
			});
		}

		if (Schema::hasTable('ward_members')) {
			Schema::table('ward_members', function($table) {
				$table->bigInteger('ward_id')->change();
				$table->smallInteger('quorum_id')->change();
			});
		}
	}
}
