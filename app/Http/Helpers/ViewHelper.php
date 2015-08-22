<?php
namespace App\Http\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

class ViewHelper {
	/**
	 * Return the given object. Useful for chaining.
	 *
	 * @param string $path   The path to check
	 * @param string $active The active class to add
	 *
	 * @return string
	 */
	static public function setActive($path, $active = 'selectedtab') {
		return Str::contains(Request::path(), $path) ? $active : '';
	}
}