<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CompanionshipFamily extends BaseModel {
	use SoftDeletes;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at'
	];
}
