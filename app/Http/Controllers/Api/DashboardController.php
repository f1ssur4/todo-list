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
		$user = $request->user();
		$tasks = $request->user()->tasks();

		$stats = [
			'total' => $tasks->count(),
			'pending' => $tasks->pending()->count(),
			'in_progress' => $tasks->inProgress()->count(),
			'completed' => $tasks->completed()->count(),
			'overdue' => $tasks->overdue()->count(),
		];

		$upcomingTasks = $user->tasks()
			->with('category:id,name,color')
			->upcoming()
			->orderBy('deadline')
			->limit(5)
			->get(['id', 'title', 'category_id', 'deadline']);
		
		$recentTasks = $user->tasks()
			->with('category:id,name,color')
			->latest()
			->limit(5)
			->get(['id', 'title', 'category_id', 'status', 'created_at']);

		return response()->json([
			'stats' => $stats,
			'upcomingTasks' => $upcomingTasks,
			'recentTasks' => $recentTasks,
		]);
	}
}
