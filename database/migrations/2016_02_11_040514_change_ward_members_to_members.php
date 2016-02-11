<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWardMembersToMembers extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable('ward_members')) {
			Schema::rename('ward_members', 'members');
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if (Schema::hasTable('members')) {
			Schema::rename('members', 'ward_members');
		}
	}
}
