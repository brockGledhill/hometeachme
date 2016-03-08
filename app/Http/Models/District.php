<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class District extends BaseModel {
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'quorum_id',
		'ward_id',
		'member_id'
	];
}
