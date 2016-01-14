<?php

namespace App\Http\Controllers\Hooks;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class PullRequestController
 *
 * @package App\Http\Controllers\Hooks
 */
class PullRequestController extends Controller {
	/**
	 * Run a pull on the QA git repo if merged into master
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postPullRequest(Request $request) {
		syslog(LOG_INFO, print_r($request->all(), true));
		exit;
	}
}
