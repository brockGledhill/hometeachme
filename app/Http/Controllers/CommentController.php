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
		$returnData = [
			'success' => true,
			'message' => 'Comment Recorded!',
			'status' => parent::MESSAGE_SUCCESS,
			'id' => $WardComment->id
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::back()->with($returnData);
	}

	public function postDelete(Request $Request) {
		$count = WardComments::destroy(Input::get('id'));
		if ($count > 0) {
			$success = true;
			$message = 'Comment Deleted';
			$status = parent::MESSAGE_SUCCESS;
		} else {
			$success = false;
			$message = 'There was a problem removing the comment...';
			$status = parent::MESSAGE_ERROR;
		}
		$returnData = [
			'success' => $success,
			'message' => $message,
			'status' => $status
		];
		if ($Request->ajax()) {
			return Response::json($returnData);
		}
		return Redirect::back()->with($returnData);
	}
}