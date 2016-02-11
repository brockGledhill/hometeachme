<?php

namespace App\Http\Models;

use Eloquence\Database\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {
	use SoftDeletes;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
}
