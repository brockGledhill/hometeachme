<?php
namespace App\Http\Controllers;

use App\Http\Models\CompanionshipVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class VisitController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postAdd(Request $Request) {
		$AuthUser = $Request->user();
		$CompanionshipVisit = CompanionshipVisit::withTrashed()->where($Request->except(['visited']))->first() ?: new CompanionshipVisit($Request->all());
		$CompanionshipVisit->wardId = $AuthUser->wardId;
		$CompanionshipVisit->quorumId = $AuthUser->quorumId;
		$CompanionshipVisit->visitYear = date('Y');
		$CompanionshipVisit->visited = $Request->get('visited');
		$CompanionshipVisit->save();

		//If soft deleted, restore.
		if ($CompanionshipVisit->trashed()) {
			$CompanionshipVisit->restore();
		}

		if ($Request->ajax()) {
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