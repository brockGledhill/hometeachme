<?php

namespace App\Http\Controllers;
use App\WardComments;
use App\WardCompanions;
use App\WardCompanionshipMembers;
use App\WardCompanionshipVisits;
use App\WardMember;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$data = [];

		$authUser = Auth::user();

		$data['authId'] = $authUser->id;
		$data['wardId'] = $authUser->ward_id;

		$WardCompanion = WardCompanions::where('ht_one_id', '=', $data['authId'])->orWhere('ht_two_id', '=', $data['authId'])->first();

		if (!empty($WardCompanion) && $WardCompanion->ht_one_id == $data['authId']) {
			$data['companion'] = WardMember::find($WardCompanion->ht_two_id);
		} else {
			$data['companion'] = WardMember::find($WardCompanion->ht_one_id);
		}
		if (!empty($data['companion'])) {
			$data['companionName'] = $data['companion']->first_name . ' ' . $data['companion']->last_name;
			$data['companionPhone'] = $data['companion']->phone;
		}

		$data['allFamilies'] = WardCompanionshipMembers::where('companionship_id', '=', $WardCompanion->id)->get();
		$data['numFamilies'] = count($data['allFamilies']);
		$data['totalVisitCount'] = 0;
		if ($data['numFamilies'] > 0) {
			foreach ($data['allFamilies'] as $key => $family) {
				$familyData = &$data['myFamilies'][$key];
				$familyData['family'] = WardMember::find($family['member_id']);
				$familyData['visitMonth'] = [];
				$visits = WardCompanionshipVisits::where('member_id', '=', $family['member_id'])->where('visit_year', '=', date('Y'))->get();
				foreach ($visits as $visit) {
					$familyData['visitMonth'][] = $visit['visit_month'];
				}
				$familyData['visitCount'] = count($visits);
				$data['totalVisitCount'] += $familyData['visitCount'];
				$familyData['comments'] = WardComments::where('member_id', '=', $data['authId'])->where('family_id', '=', $family['member_id'])->get();
			}
		}

		$data['months'] = [
			'Jan' => 'January',
			'Feb' => 'February',
			'Mar' => 'March',
			'Apr' => 'April',
			'May' => 'May',
			'Jun' => 'June',
			'Jul' => 'July',
			'Aug' => 'August',
			'Sep' => 'September',
			'Oct' => 'October',
			'Nov' => 'November',
			'Dec' => 'December'
		];

		$data['myHomeTeachers'] = WardCompanionshipMembers::where('member_id', '=', $data['authId'])->get();
		$data['numHomeTeachers'] = count($data['myHomeTeachers']);
		if ($data['numHomeTeachers'] > 0) {
			foreach ($data['myHomeTeachers'] as $key => $homeTeacher) {
				$homeTeacherData = &$data['myHomeTeacherFamily'][$key];
				$homeTeacherData['family'] = WardMember::find($homeTeacher['member_id']);
			}
		}

		return view('dashboard', $data);
	}

	public function postIndex() {
		
	}
}