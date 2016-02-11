<?php

namespace App\Http\Models;

use Eloquence\Database\Model;

class District extends Model {
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
