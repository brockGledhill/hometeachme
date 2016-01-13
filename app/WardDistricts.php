<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WardDistricts extends Model {
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
