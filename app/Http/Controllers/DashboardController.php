<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function __invoke(Request $request): View
	{
		$tasks = $request->user()->tasks();

		$stats = [
			'total' => $tasks->count(),
			'pending' => $tasks->pending()->count(),
			'in_progress' => $tasks->inProgress()->count(),
			'completed' => $tasks->completed()->count(),
			'overdue' => $tasks->overdue()->count(),
		];

		$upcomingTasks = $tasks
			->with('category')
			->upcoming()
			->orderBy('deadline')
			->limit(5)
			->get();

		$recentTasks = $tasks
			->with('category')
			->latest()
			->limit(5)
			->get();

		return view('dashboard', compact('stats', 'upcomingTasks', 'recentTasks'));
	}
}
