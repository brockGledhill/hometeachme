<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Stake extends BaseModel {
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}