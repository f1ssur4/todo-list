<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class TaskService
 */
class TaskService
{
	/**
	 * @param User $user
	 * @param array $filters
	 * @return LengthAwarePaginator
	 */
	public function getFilteredTasks(User $user, array $filters): LengthAwarePaginator
	{
		$query = $user->tasks()->with('category');

		if (!empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}

		if (!empty($filters['priority'])) {
			$query->where('priority', $filters['priority']);
		}

		if (!empty($filters['category_id'])) {
			$query->where('category_id', $filters['category_id']);
		}

		if (!empty($filters['search'])) {
			$search = $filters['search'];
			$query->where(function ($q) use ($search) {
				$q->where('title', 'like', "%{$search}%")
				  ->orWhere('description', 'like', "%{$search}%");
			});
		}

		return $query->latest()->paginate(15)->withQueryString();
	}

	/**
	 * @param User $user
	 * @param array $data
	 * @return Task
	 */
	public function create(User $user, array $data): Task
	{
		return $user->tasks()->create($data);
	}

	/**
	 * @param Task $task
	 * @param array $data
	 * @return Task
	 */
	public function update(Task $task, array $data): Task
	{
		if (isset($data['status']) && $data['status'] === 'completed' && $task->status !== 'completed') {
			$data['completed_at'] = now();
		}

		if (isset($data['status']) && $data['status'] !== 'completed') {
			$data['completed_at'] = null;
		}

		$task->update($data);

		return $task->fresh();
	}

	/**
	 * @param Task $task
	 * @return bool
	 */
	public function delete(Task $task): bool
	{
		return $task->delete();
	}

	/**
	 * @param Task $task
	 * @return Task
	 */
	public function toggleStatus(Task $task): Task
	{
		$statusFlow = [
			'pending' => 'in_progress',
			'in_progress' => 'completed',
			'completed' => 'pending',
		];

		$newStatus = $statusFlow[$task->status];

		return $this->update($task, ['status' => $newStatus]);
	}
}
