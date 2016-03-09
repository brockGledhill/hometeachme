<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 *
 * @package App\Http\Models
 */
class Comment extends BaseModel {
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

	/**
	 * Companionship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function companionship() {
		return $this->belongsTo(Companionship::class)->withTrashed();
	}

	/**
	 * Family
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function family() {
		return $this->belongsTo(Member::class, 'family_id');
	}

	/**
	 * Member
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function member() {
		return $this->belongsTo(Member::class)->withTrashed();
	}
}
