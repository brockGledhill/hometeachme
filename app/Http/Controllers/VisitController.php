<?php
namespace App\Http\Controllers;

use App\Http\Models\CompanionshipVisit;
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
		$CompanionshipVisit = CompanionshipVisit::withTrashed()->where(Input::get())->first() ?: new CompanionshipVisit(Input::get());
		$CompanionshipVisit->ward_id = $AuthUser->ward_id;
		$CompanionshipVisit->quorum_id = $AuthUser->quorum_id;
		$CompanionshipVisit->visit_year = date('Y');
		$CompanionshipVisit->save();

		//If soft deleted, restore.
		if ($CompanionshipVisit->trashed()) {
			$CompanionshipVisit->restore();
		}

		if (Request::ajax()) {
			return Response::json(['success' => true, 'status' => 'Visit Recorded!']);
		}
		return Redirect::back()->with('status', 'Visit Recorded!');
	}

	public function postDelete() {
		$CompanionshipVisit = CompanionshipVisit::where(Input::get())->first();
		$CompanionshipVisit->delete();

		if (Request::ajax()) {
			return Response::json(['success' => true, 'status' => 'Visit Removed']);
		}
		return Redirect::back()->with('status', 'Visit Removed');
	}
}