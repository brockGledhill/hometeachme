<?php

namespace app\Http\Models;

use Eloquence\Database\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quorum extends Model {
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}