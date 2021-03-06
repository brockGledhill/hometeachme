<?php
namespace app\Http\Controllers;

use App\Http\Models\CompanionshipFamily;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CompanionshipMemberController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postAdd() {
		CompanionshipFamily::create(Input::all());
		return Redirect::back()->with('status', 'Family Added!');
	}

	public function postDelete() {
		CompanionshipFamily::destroy(Input::get('id'));
		return Redirect::back()->with('status', 'Family Removed.');
	}
}