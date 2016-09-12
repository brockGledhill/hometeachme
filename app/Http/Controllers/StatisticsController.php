<?php
namespace app\Http\Controllers;

use App\Http\Models\CompanionshipVisit;
use App\Http\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Get the stats page
	 *
	 * @param Request $Request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex(Request $Request) {
		$requestData = $Request->all();
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$year = $curYear = (int)date('Y');
		if (!empty($requestData['year'])) {
			$year = (int)$requestData['year'];
		}
		$data['firstYear'] = 2015;
		$data['nowYear'] = $curYear;
		$data['selectedYear'] = $year;
		$data['visitMonths'] = CompanionshipVisit::where('ward_id', '=', $authUser->ward_id)
			->select(DB::raw("*, COUNT(*) AS count, FIELD(visit_month,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') AS month_order"))
			->where('quorum_id', '=', $authUser->quorum_id)
			->where('visit_year', '=', $data['selectedYear'])
			->where('visited', '=', 'yes')
			->groupBy('visit_month')
			->having('count', '>', 0)
			->orderBy("month_order")
			->get();
		$data['members'] = [];
		foreach ($data['visitMonths'] as $month) {
			$Families = CompanionshipVisit::where('visit_month', '=', $month['visit_month'])
				->where('ward_id', '=', $authUser->ward_id)
				->where('quorum_id', '=', $authUser->quorum_id)
				->where('visit_year', '=', $data['selectedYear'])
				->where('visited', '=', 'yes')
				->get();
			foreach ($Families as $Family) {
				try {
					$data['members'][$month['visit_month']][] = Member::withTrashed()->findOrFail($Family->member_id);
				} catch (Exception $exception) {
					continue;
				}
			}

			if (!empty($data['members'][$month['visit_month']])) {
				usort($data['members'][$month['visit_month']], function($one, $two) {
					//Compare by last name first followed by first name.
					return strcmp($one->lastName . $one->firstName, $two->lastName . $two->firstName);
				});
			}
		}

		return view('stats', $data);
	}
}