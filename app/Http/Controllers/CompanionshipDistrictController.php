<?php
namespace app\Http\Controllers;

use App\WardCompanions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CompanionshipDistrictController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postUpdate() {

		if (Request::isMethod('post')) {
			$WardCompanions = WardCompanions::find(Input::get('id'));
			$WardCompanions->district_id = Input::get('district_id');
			$WardCompanions->update();
		}
		return Redirect::back()->with('status', 'Companionship District Removed.');
	}
}