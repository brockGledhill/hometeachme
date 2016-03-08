<?php

namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Member extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
	protected $guarded = [
		'id',
		'is_assigned',
		'quorum_id',
		'ward_id',
		'is_jr_comp'
	];

	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

	/**
	 * Save a new, or update an existing ward member (singular)
	 *
	 * @param array $attributes
	 *
	 * @return bool|int
	 */
	public function saveMember(array $attributes = []) {
		$this->first_name = $attributes['first_name'];
		$this->last_name = $attributes['last_name'];
		$this->spouse_name = $attributes['spouse_name'];

		$replaced = preg_replace('/[\(\)\-\s]/', '', $attributes['phone']);
		if (strlen($replaced) === 10) {
			$phone = '(' . $replaced[0] .  $replaced[1] . $replaced[2] . ') ' .  $replaced[3] . $replaced[4] . $replaced[5] . '-' . $replaced[6] . $replaced[7] . $replaced[8] . $replaced[9];
		} else {
			$phone = $attributes['phone'];
		}
		$this->phone = $phone;
		$this->email = $attributes['email'];

		if (!empty($attributes['password'])) {
			$password = trim($attributes['password']);
			$this->password = Hash::make($password);
		}
		if (!empty($attributes['ward_id'])) {
			$this->ward_id = $attributes['ward_id'];
		}
		if (!empty($attributes['quorum_id'])) {
			$this->quorum_id = $attributes['quorum_id'];
		}
		if (!empty($attributes['is_admin'])) {
			$this->is_admin = toBool($attributes['is_admin']);
		}
		if (isset($attributes['is_jr_comp'])) {
			$this->is_jr_comp = toBool($attributes['is_jr_comp']);
		}
		return parent::save();
	}

	/*public function hashPasswords() {
		$WardMembers = WardMember::all();
		foreach ($WardMembers as $WardMember) {
			if (!empty($WardMember->password)) {
				$newWardMember = WardMember::find($WardMember->id);
				$newWardMember->password = Hash::make($WardMember->password);
				$newWardMember->save();
			}
		}
		echo "DONE!";
		exit;
	}*/
}