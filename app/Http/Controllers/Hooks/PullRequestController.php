<?php

namespace App\Http\Controllers\Hooks;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

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
	public function postPullRequest(Request $Request) {
		$request = $Request->all();
		if (App::environment() === 'qa' && $request['action'] === 'closed' && $request['pull_request']['merged'] === true && $request['pull_request']['base']['ref'] === 'qa') {
			exec('cd /var/www/qa.hometeachme.org/ && git pull');
		}
		return new Response('pull request received!', 200);
	}
}
