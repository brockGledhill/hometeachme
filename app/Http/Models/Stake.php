<?php

namespace App\Http\Models;

use Eloquence\Database\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stake extends Model {
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}