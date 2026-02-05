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
		$user = $request->user();

		$stats = [
			'total' => $user->tasks()->count(),
			'pending' => $user->tasks()->pending()->count(),
			'in_progress' => $user->tasks()->inProgress()->count(),
			'completed' => $user->tasks()->completed()->count(),
			'overdue' => $user->tasks()->overdue()->count(),
		];

		$upcomingTasks = $user->tasks()
			->with('category')
			->upcoming()
			->orderBy('deadline')
			->limit(5)
			->get();

		$recentTasks = $user->tasks()
			->with('category')
			->latest()
			->limit(5)
			->get();

		return view('dashboard', compact('stats', 'upcomingTasks', 'recentTasks'));
	}
}
