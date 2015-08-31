<?php
namespace app\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class PasswordController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getUpdate() {
		$data['WardMember'] = Auth::user();
		return view('members.password.update', $data);
	}

	public function postUpdate(Request $Request) {
		$AuthUser = Auth::user();
		$data = Input::get();
		if (Hash::check($data['current_password'], $AuthUser->password) && $data['new_password_1'] === $data['new_password_2']) {
			$AuthUser->password = Hash::make($data['new_password_1']);
			$AuthUser->save();
		}
		$status = 'Password Updated!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::to('/profile')->with('status', $status);
	}
}