<?php
namespace app\Http\Controllers;

use App\Http\Models\WardMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class MemberController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$authUser = Auth::user();
		$data['quorumId'] = $authUser->quorum_id;
		$data['wardId'] = $authUser->ward_id;
		$data['families'] = WardMember::where('ward_id', '=', $authUser->ward_id)->where('quorum_id', '=', $authUser->quorum_id)->orderBy('last_name', 'asc')->get();
		return view('members', $data);
	}

	public function getEdit() {
		$id = Input::get('id');
		if (empty($id)) {
			return Redirect::back()->with('error', 'Invalid Member Requested');
		}
		$WardMember = WardMember::find($id);
		if (empty($WardMember->id)) {
			return Redirect::back()->with('error', 'Invalid Member Requested');
		}
		$data['WardMember'] = $WardMember;
		return view('members.edit', $data);
	}

	public function postAdd(Request $Request) {
		$WardMember = new WardMember();
		$WardMember->saveMember(Input::get());
		$status = 'Member Added!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postUpdate(Request $Request) {
		$WardMember = WardMember::find(Input::get('id'));
		$WardMember->saveMember(Input::get());
		$status = 'Member Updated!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postDelete(Request $Request) {
		WardMember::destroy(Input::get('id'));
		$status = 'Member Removed';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}
}