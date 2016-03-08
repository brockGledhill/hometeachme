<?php
namespace app\Http\Controllers;

use App\Http\Models\Companionship;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CompanionshipDistrictController extends Controller {
	/**
	 * CompanionshipDistrictController constructor.
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Post Update
	 *
	 * @return Redirect
	 */
	public function postUpdate() {
		$Companionship = Companionship::find(Input::get('id'));
		$Companionship->district_id = Input::get('district_id');
		$Companionship->update();
		return Redirect::back()->with('status', 'Companionship District Removed.');
	}
}