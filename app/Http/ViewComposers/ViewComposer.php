<?php
namespace App\Http\ViewComposers;

use app\Http\Models\Member;
use Illuminate\Auth\AuthManager;
use Illuminate\View\View;

class ViewComposer {
	/**
	 * @var Member
	 */
	private $authUser;

	/**
	 * ViewComposer constructor.
	 *
	 * @param AuthManager $auth The auth manager
	 */
	public function __construct(AuthManager $auth) {
		$this->authUser = $auth->user();
	}

	/**
	 * Compose
	 *
	 * @param View $view The view
	 *
	 * @return void
	 */
	public function compose(View $view) {
		if ($this->authUser) {
			$view->with('adminStatus', $this->authUser->isAdmin);
		}
	}
}