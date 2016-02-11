<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuorumsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::beginTransaction();

		Schema::create('quorums', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('ward_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
		});

		$ward = DB::table('wards')->where('name', '=', 'Canyon Point Ward')->first();

		$now = date('Y-m-d H:i:s');
		DB::table('quorums')->insert([
			'name' => 'Elders Quorum',
			'ward_id' => $ward->id,
			'created_at' => $now,
			'updated_at' => $now
		]);

		DB::table('quorums')->insert([
			'name' => 'Priests Quorum',
			'ward_id' => $ward->id,
			'created_at' => $now,
			'updated_at' => $now
		]);

		DB::commit();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('quorums');
	}
}
