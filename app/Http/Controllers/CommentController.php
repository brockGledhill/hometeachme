<?php
namespace App\Http\Controllers;

use App\WardComments;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CommentController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function postAdd(Request $Request) {
		$WardComment = WardComments::create(array_merge(Input::all(), ['visit_year' => date('Y')]));
		$status = 'Comment Recorded!';
		if ($Request->ajax()) {
			return Response::json(['success' => true, 'status' => $status, 'id' => $WardComment->id]);
		}
		return Redirect::back()->with('status', $status);
	}

	public function postDelete(Request $Request) {
		$success = WardComments::destroy(Input::get('id'));
		if ($success) {
			$status = 'Comment Deleted';
		} else {
			$status = 'There was a problem removing the comment...';
		}
		if ($Request->ajax()) {
			return Response::json(['success' => $success, 'status' => $status]);
		}
		return Redirect::back()->with('status', $status);
	}
}