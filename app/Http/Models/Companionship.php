<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Companionship
 *
 * @package App\Http\Models
 */
class Companionship extends BaseModel {
	use SoftDeletes;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
		'created_at',
		'updated_at'
	];
}
