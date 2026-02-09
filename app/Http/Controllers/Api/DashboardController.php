<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function __invoke(Request $request): JsonResponse
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

		return response()->json([
			'stats' => $stats,
			'upcomingTasks' => $upcomingTasks,
			'recentTasks' => $recentTasks,
		]);
	}
}
