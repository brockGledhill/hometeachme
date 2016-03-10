<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveWardIdFromComments extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::transaction(function() {
			$newDate = '2016-01-01 00:00:00';

			if (Schema::hasTable('comments')) {
				if (!Schema::hasColumn('comments', 'companionship_id')) {
					Schema::table('comments', function (Blueprint $table) {
						$table->integer('companionship_id')->unsigned()->after('member_id');
					});
				}

				DB::update('UPDATE comments SET created_at = ?, updated_at = ? WHERE created_at = ?', [$newDate, $newDate, '0000-00-00 00:00:00']);
				DB::update('UPDATE ward_companions SET created_at = ?, updated_at = ? WHERE created_at = ?', [$newDate, $newDate, '0000-00-00 00:00:00']);

				$companionships = DB::select('
					SELECT c.id AS commentId, c.member_id AS commentMemberId, c.companion_id AS commentCompanion, wc.*, c.family_id
					FROM comments AS c
					LEFT JOIN ward_companions AS wc
					ON (ht_one_id = c.member_id OR ht_one_id = c.companion_id)
					AND (ht_two_id = c.member_id OR ht_two_id = c.companion_id)
					ORDER BY commentId ASC'
				);

				$date = '2000-01-01 00:00:00';
				foreach ($companionships as $companionship) {
					if (empty($companionship->id)) {
						$member = DB::table('members')->find($companionship->commentMemberId);
						DB::table('ward_companions')->insert([
							'ht_one_id' => $companionship->commentMemberId,
							'ht_two_id' => $companionship->commentCompanion,
							'ward_id' => $member->ward_id,
							'district_id' => 0,
							'quorum_id' => $member->quorum_id,
							'family_id' => $companionship->family_id,
							'created_at' => $date,
							'updated_at' => $date,
							'deleted_at' => $date
						]);
						$companionship->id = DB::getPdo()->lastInsertId();
					}
					DB::update('UPDATE comments SET companionship_id = ? WHERE id = ?', [$companionship->id, $companionship->commentId]);
				}

				Schema::table('comments', function(Blueprint $table) {
					$table->dropColumn(['ward_id', 'companion_id']);
				});
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::transaction(function() {
			if (Schema::hasTable('comments')) {
				Schema::table('comments', function(Blueprint $table) {
					$table->integer('ward_id')->unsigned()->after('family_id');
					$table->integer('companion_id')->unsigned()->after('family_id');
				});

				DB::update('
					UPDATE comments AS c
					LEFT JOIN ward_companions AS wc
					ON c.companionship_id = wc.id
					SET c.ward_id = wc.ward_id, c.member_id = wc.ht_one_id, c.companion_id = wc.ht_two_id
				');

				Schema::table('comments', function(Blueprint $table) {
					$table->dropColumn('companionship_id');
				});
			}
		});
	}
}
