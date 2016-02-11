<?php
namespace app\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Models\WardMember;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


class PasswordController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getReset() {
		$data['WardMember'] = WardMember::find(Input::get('id'));
		return view('members.password.reset', $data);
	}

	public function postReset(Request $Request) {
		$WardMember = WardMember::find(Input::get('id'));
		$WardMember->password = Hash::make('hometeach');
		$WardMember->save();
		$returnData = [
			'success' => true,
			'message' => 'Password Reset for ' . $WardMember->first_name . ' ' . $WardMember->last_name . '!',
			'status' => parent::MESSAGE_SUCCESS
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::to('/members/edit?id=' . $WardMember->id)->with($returnData);
	}
}