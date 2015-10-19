<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
	use DispatchesJobs, ValidatesRequests;
	const MESSAGE_ERROR = 'alert-danger';
	const MESSAGE_INFO = 'alert-info';
	const MESSAGE_SUCCESS = 'alert-success';
	const MESSAGE_WARNING = 'alert-warning';
}
