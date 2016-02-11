<?php
namespace app\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Models\Member;
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
		$data['WardMember'] = Member::find(Input::get('id'));
		return view('members.password.reset', $data);
	}

	public function postReset(Request $Request) {
		$Member = Member::find(Input::get('id'));
		$Member->password = Hash::make('hometeach');
		$Member->save();
		$returnData = [
			'success' => true,
			'message' => 'Password Reset for ' . $Member->firstName . ' ' . $Member->lastName . '!',
			'status' => parent::MESSAGE_SUCCESS
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::to('/members/edit?id=' . $Member->id)->with($returnData);
	}
}