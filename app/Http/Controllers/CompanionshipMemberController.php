<?php
namespace app\Http\Controllers;

use App\WardCompanionshipMembers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CompanionshipMemberController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postAdd() {
		if (Request::isMethod('post')) {
			WardCompanionshipMembers::create(Input::all());
		}
		return Redirect::back()->with('status', 'Family Added!');
	}

	public function postDelete() {
		if (Request::isMethod('post')) {
			WardCompanionshipMembers::destroy(Input::get('id'));
		}
		return Redirect::back()->with('status', 'Family Removed.');
	}
}