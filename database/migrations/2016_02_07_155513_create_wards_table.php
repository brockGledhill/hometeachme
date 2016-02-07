<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWardsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::beginTransaction();

		Schema::create('wards', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->bigInteger('stake_id');
			$table->softDeletes();
			$table->timestamps();
		});

		$stake = DB::table('stakes')->where('name', '=', 'Canyon Ridge Stake')->first();

		$now = date('Y-m-d H:i:s');
		DB::table('wards')->insert([
			'name' => 'Canyon Point Ward',
			'stake_id' => $stake->id,
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
		Schema::drop('wards');
	}
}
