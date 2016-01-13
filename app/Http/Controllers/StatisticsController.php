<?php
namespace app\Http\Controllers;

use App\WardCompanionshipVisits;
use App\WardMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$data['visitMonths'] = WardCompanionshipVisits::where('ward_id', '=', $authUser->ward_id)
			->select(DB::raw("*, COUNT(*) AS count, FIELD(visit_month,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') AS month_order"))
			->where('quorum_id', '=', $authUser->quorum_id)
			->groupBy('visit_month')
			->having('count', '>', 0)
			->orderBy("month_order")
			->get();
		$data['members'] = [];
		foreach ($data['visitMonths'] as $month) {
			$Families = WardCompanionshipVisits::where('visit_month', '=', $month['visit_month'])->where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
			foreach ($Families as $Family) {
				$data['members'][$month['visit_month']][] = WardMember::find($Family->member_id);
			}
		}

		return view('stats', $data);
	}
}