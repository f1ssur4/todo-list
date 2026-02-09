<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
	/**
	 * @return View
	 */
	public function __invoke(): View
	{
		return view('dashboard');
	}
}
