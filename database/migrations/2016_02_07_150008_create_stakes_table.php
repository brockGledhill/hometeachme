<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::beginTransaction();

		Schema::create('stakes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->softDeletes();
			$table->timestamps();
		});

		$now = date('Y-m-d H:i:s');
		DB::table('stakes')->insert([
			'name' => 'Canyon Ridge Stake',
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
		Schema::drop('stakes');
	}
}