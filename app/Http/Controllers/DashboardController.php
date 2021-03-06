<?php

namespace App\Http\Controllers;
use App\Http\Models\Comment;
use App\Http\Models\Companionship;
use App\Http\Models\CompanionshipFamily;
use App\Http\Models\CompanionshipVisit;
use App\Http\Models\Member;
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

		$data['companionship'] = Companionship::where('ht_one_id', '=', $data['authId'])->orWhere('ht_two_id', '=', $data['authId'])->first();

		$data['allFamilies'] = [];
		if (!empty($data['companionship'])) {
			if ($data['companionship']->ht_one_id == $data['authId']) {
				$data['companion'] = Member::find($data['companionship']->ht_two_id);
			} else {
				$data['companion'] = Member::find($data['companionship']->ht_one_id);
			}
			$data['allFamilies'] = CompanionshipFamily::where('companionship_id', '=', $data['companionship']->id)->get();
		}
		if (!empty($data['companion'])) {
			$data['companionName'] = $data['companion']->first_name . ' ' . $data['companion']->last_name;
			$data['companionPhone'] = $data['companion']->phone;
		}

		$data['numFamilies'] = count($data['allFamilies']);
		$data['totalVisitCount'] = 0;
		if ($data['numFamilies'] > 0) {
			foreach ($data['allFamilies'] as $key => $family) {
				$count = 0;
				$familyData = &$data['myFamilies'][$key];
				$familyData['family'] = Member::find($family['member_id']);
				$familyData['visitMonth'] = [];
				$familyData['visitMonthYes'] = [];
				$familyData['visitMonthNo'] = [];
				$visits = CompanionshipVisit::where('member_id', '=', $family['member_id'])->where('visit_year', '=', date('Y'))->get();
				foreach ($visits as $visit) {
					$familyData['visitMonth'][] = $visit->visitMonth;
					if ($visit->visited === 'yes') {
						$familyData['visitMonthYes'][] = $visit->visitMonth;
						++$count;
					} else {
						$familyData['visitMonthNo'][] = $visit->visitMonth;
					}
				}
				$familyData['visitCount'] = $count;
				$data['totalVisitCount'] += $familyData['visitCount'];
				$familyData['comments'] = Comment::whereHas('companionship', function($query) use ($data) {
						$query->where('ht_one_id', '=', $data['authId'])->orWhere('ht_two_id', '=', $data['authId']);
					})
					->where('family_id', '=', $family['member_id'])
					->get();
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

		$compMemberRow = CompanionshipFamily::where('member_id', '=', $data['authId'])->first();
		$data['myHomeTeachers'] = [];
		if ($compMemberRow) {
			$compRow = Companionship::where('id', '=', $compMemberRow->companionship_id)->first();
			$data['numHomeTeachers'] = 0;
			if (!empty($compRow->ht_one_id)) {
				$data['myHomeTeachers'][1] = Member::find($compRow->ht_one_id);
				++$data['numHomeTeachers'];
			}
			if (!empty($compRow->ht_two_id)) {
				$data['myHomeTeachers'][2] = Member::find($compRow->ht_two_id);
				++$data['numHomeTeachers'];
			}
		}

		$data['year'] = date('Y');
		return view('dashboard', $data);
	}
}