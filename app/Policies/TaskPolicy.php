<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

/**
 * Class TaskPolicy
 */
class TaskPolicy
{
	/**
	 * @param User $user
	 * @return bool
	 */
	public function viewAny(User $user): bool
	{
		return true;
	}

	/**
	 * @param User $user
	 * @param Task $task
	 * @return bool
	 */
	public function view(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function create(User $user): bool
	{
		return true;
	}

	/**
	 * @param User $user
	 * @param Task $task
	 * @return bool
	 */
	public function update(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}

	/**
	 * @param User $user
	 * @param Task $task
	 * @return bool
	 */
	public function delete(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}

	/**
	 * @param User $user
	 * @param Task $task
	 * @return bool
	 */
	public function restore(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}

	/**
	 * @param User $user
	 * @param Task $task
	 * @return bool
	 */
	public function forceDelete(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}
}
