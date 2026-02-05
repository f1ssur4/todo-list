<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

/**
 * Class CategoryPolicy
 */
class CategoryPolicy
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
	 * @param Category $category
	 * @return bool
	 */
	public function view(User $user, Category $category): bool
	{
		return $user->id === $category->user_id;
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
	 * @param Category $category
	 * @return bool
	 */
	public function update(User $user, Category $category): bool
	{
		return $user->id === $category->user_id;
	}

	/**
	 * @param User $user
	 * @param Category $category
	 * @return bool
	 */
	public function delete(User $user, Category $category): bool
	{
		return $user->id === $category->user_id;
	}
}
