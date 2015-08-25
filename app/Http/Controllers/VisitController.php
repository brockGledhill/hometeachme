<?php
namespace App\Http\Controllers;

use App\WardCompanionshipVisits;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;

class VisitController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postAdd() {
		$AuthUser = Auth::user();
		$WardCompanionshipVisit = WardCompanionshipVisits::withTrashed()->where(Input::all())->first() ?: new WardCompanionshipVisits(Input::all());
		$WardCompanionshipVisit->ward_id = $AuthUser->ward_id;
		$WardCompanionshipVisit->quorum_id = $AuthUser->quorum_id;
		$WardCompanionshipVisit->visit_year = date('Y');
		$WardCompanionshipVisit->save();

		//If soft deleted, restore.
		if ($WardCompanionshipVisit->trashed()) {
			$WardCompanionshipVisit->restore();
		}

		if (Request::ajax()) {
			return Response::json(['success' => true, 'status' => 'Visit Recorded!']);
		}
		return Redirect::back()->with('status', 'Visit Recorded!');
	}

	public function postDelete() {
		$AuthUser = Auth::user();
		$WardCompanionshipVisit = WardCompanionshipVisits::firstOrNew(Input::all());
		$WardCompanionshipVisit->delete();

		if (Request::ajax()) {
			return Response::json(['success' => true, 'status' => 'Visit Removed']);
		}
		return Redirect::back()->with('status', 'Visit Removed');
	}
}