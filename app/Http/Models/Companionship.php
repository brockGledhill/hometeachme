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
		'id',
		'created_at',
		'updated_at'
	];

	/**
	 * HtOne member
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function htOne() {
		return $this->belongsTo(Member::class);
	}

	/**
	 * HtTwo member
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function htTwo() {
		return $this->belongsTo(Member::class);
	}

	/**
	 * Comments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comment() {
		return $this->hasMany(Comment::class, 'companion_id');
	}
}
