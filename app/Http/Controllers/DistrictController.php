<?php
namespace app\Http\Controllers;

use App\Http\Models\District;
use App\Http\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DistrictController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$data['families'] = Member::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		$districts = District::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->get();
		$data['districts'] = [];
		foreach ($districts as $district) {
			$data['districts'][] = Member::find($district->member_id);
		}
		return view('districts', $data);
	}

	public function postIndex() {
		District::create(Input::all());
		return Redirect::back()->with('status', 'District Added!');
	}
}