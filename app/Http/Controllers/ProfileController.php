<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$data['myInfo'] =  Auth::user();
		return view('profile', $data);
	}

	public function postIndex() {
		$Member = Auth::user();
		$Member->saveMember(Input::all());
		return Redirect::back()->with('status', 'Profile Updated!');
	}
}