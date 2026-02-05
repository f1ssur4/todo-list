<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Task;
use App\Policies\CategoryPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 */
class AppServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function register(): void
	{
	}

	/**
	 * @return void
	 */
	public function boot(): void
	{
		Gate::policy(Task::class, TaskPolicy::class);
		Gate::policy(Category::class, CategoryPolicy::class);
	}
}
