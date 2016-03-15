<?php
namespace app\Http\Controllers;

use App\Http\Models\Companionship;
use App\Http\Models\CompanionshipFamily;
use App\Http\Models\District;
use App\Http\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CompanionshipController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;

		$data['families'] = Member::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$data['numOfFamilies'] = count($data['families']);
		$data['districtList'] = District::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districtMembers'] = [];
		foreach ($data['districtList'] as $key => $district) {
			$data['districtMembers'][$key] = Member::find($district->member_id);
		}

		$data['existingHomeTeachers'] = Companionship::select('companionships.*')
			->leftJoin('members', 'companionships.ht_one_id', '=', 'members.id')
			->where('companionships.ward_id', '=', $authUser->wardId)
			->where('companionships.quorum_id', '=', $authUser->quorumId)
			->orderBy('members.last_name', 'ASC')
			->get();
		$data['existingHomeTeacherCompanion'] = $this->getExistingHomeTeacherCompanionData($data['existingHomeTeachers']);

		$checkForUnassignedMembers = Member::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorumId)->where('is_jr_comp', '=', false)->get();
		$data['unassignedFamilies'] = [];
		foreach ($checkForUnassignedMembers as $unassigned) {
			$companionshipFamily = CompanionshipFamily::where('member_id', '=', $unassigned->id)->get();

			// If family doesn't exist in the comps relationship table
			if ($companionshipFamily->isEmpty()) {
				$data['unassignedFamilies'][] = Member::find($unassigned->id);
			}
		}

		$data['unassignedHomeTeachers'] = [];
		foreach ($data['families'] as $family) {
			$companionshipFamily = Companionship::where('ht_one_id', '=', $family->id)->orWhere('ht_two_id', '=', $family->id)->first();
			if (empty($companionshipFamily) || empty($companionshipFamily->id)) {
				$data['unassignedHomeTeachers'][] = Member::find($family->id);
			}
		}

		return view('companionships', $data);
	}

	public function getEdit() {
		$id = Input::get('id');
		if (empty($id)) {
			return Redirect::back()->with('status', 'Invalid member.');
		}
		$data['Member'] = Member::find($id);
		if (empty($data['WardMember']) || empty($data['WardMember']->id)) {
			return Redirect::to('/members');
		}

		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;

		$data['searchResult'] = Input::get('name');
		$data['existingHomeTeachers'] = Companionship::where('ward_id' ,'=', $authUser->ward_id)
			->where('quorum_id' ,'=', $authUser->quorum_id)
			->where(function($query) use ($id) {
				$query->where('ht_one_id', '=', $id)->orWhere('ht_two_id', '=', $id);
			})
			->get();

		$data['existingHomeTeacherCompanion'] = $this->getExistingHomeTeacherCompanionData($data['existingHomeTeachers']);
		$data['families'] = Member::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$data['districtList'] = District::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districtMembers'] = [];
		foreach ($data['districtList'] as $key => $district) {
			$data['districtMembers'][$key] = Member::find($district->member_id);
		}

		return view('companionships.edit', $data);
	}

	public function postAdd(Request $Request) {
		$Companionship = Companionship::create(Input::except('member_id'));
		foreach (Input::get('member_id') as $memberId) {
			$CompanionshipFamily = new CompanionshipFamily();
			$CompanionshipFamily->member_id = $memberId;
			$CompanionshipFamily->companionship_id = $Companionship->id;
			$CompanionshipFamily->save();
		}
		$status = 'Companionship Added With Families!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postUpdate(Request $Request) {
		$request = $Request->all();
		$Companionship = Companionship::find($request['id']);

		$NewCompanionship = $Companionship->replicate();
		if (isset($request['ht_one_id'])) {
			$NewCompanionship->htOneId = empty($request['ht_one_id']) ? null : $request['ht_one_id'];
		} elseif (isset($request['ht_two_id'])) {
			$NewCompanionship->htTwoId = empty($request['ht_two_id']) ? null : $request['ht_two_id'];
		} else {
			return Redirect::back()->with('status', 'Issue updating the companionship.');
		}

		$NewCompanionship->save();

		$CompanionshipFamilies = CompanionshipFamily::where('companionship_id', '=', $Companionship->id)->get();
		$CompanionshipFamilies->each(function($CompanionshipFamily) use($NewCompanionship) {
			$NewWardCompanionshipMember = $CompanionshipFamily->replicate();
			$NewWardCompanionshipMember->companionship_id = $NewCompanionship->id;
			$NewWardCompanionshipMember->save();
		});

		$Companionship->delete();

		return Redirect::back()->with('status', 'Companionship updated.');
	}

	public function postDelete(Request $Request) {
		$id = Input::get('id');
		Companionship::destroy($id);
		CompanionshipFamily::where('companionship_id', '=', $id)->delete();
		$status = 'Companionship Removed.';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	private function getExistingHomeTeacherCompanionData($existingHomeTeachers) {
		$existingHomeTeacherCompanion = [];
		foreach ($existingHomeTeachers as $key => $homeTeachers) {
			$existingHomeTeacherCompanion[$key]['homeTeacher'][1] =  Member::find($homeTeachers->ht_one_id);
			$existingHomeTeacherCompanion[$key]['homeTeacher'][2] = Member::find($homeTeachers->ht_two_id);
			$families =  CompanionshipFamily::where('companionship_id', '=', $homeTeachers->id)->get();
			$existingHomeTeacherCompanion[$key]['families'] = [];
			foreach ($families as $family) {
				$taughtFamily = &$existingHomeTeacherCompanion[$key]['families'][];
				$taughtFamily = Member::find($family->member_id);
				$taughtFamily['ward_companionship_member_id'] = $family->id;
			}
			$district = District::find($homeTeachers->district_id);
			if ($district) {
				$existingHomeTeacherCompanion[$key]['districtMember'] = Member::find($district->member_id);
			}
		}
		return $existingHomeTeacherCompanion;
	}
}