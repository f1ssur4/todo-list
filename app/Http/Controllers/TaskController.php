<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class TaskController
 */
class TaskController extends Controller
{
	/**
	 * @param TaskService $taskService
	 */
	public function __construct(
		private readonly TaskService $taskService
	) {}

	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$filters = $request->only(['status', 'priority', 'category_id', 'search']);

		$tasks = $this->taskService->getFilteredTasks(
			$request->user(),
			$filters
		);

		$categories = $request->user()->categories()->get();

		return view('tasks.index', compact('tasks', 'filters', 'categories'));
	}

	/**
	 * @param Request $request
	 * @return View
	 */
	public function create(Request $request): View
	{
		$categories = $request->user()->categories()->get();

		return view('tasks.create', compact('categories'));
	}

	/**
	 * @param StoreTaskRequest $request
	 * @return RedirectResponse
	 */
	public function store(StoreTaskRequest $request): RedirectResponse
	{
		$this->taskService->create(
			$request->user(),
			$request->validated()
		);

		return redirect()
			->route('tasks.index')
			->with('success', 'Task created successfully.');
	}

	/**
	 * @param Task $task
	 * @return View
	 * @throws AuthorizationException
	 */
	public function show(Task $task): View
	{
		$this->authorize('view', $task);

		return view('tasks.show', compact('task'));
	}
	
	/**
	 * @param Request $request
	 * @param Task $task
	 * @return View
	 * @throws AuthorizationException
	 */
	public function edit(Request $request, Task $task): View
	{
		$this->authorize('update', $task);

		$categories = $request->user()->categories()->get();

		return view('tasks.edit', compact('task', 'categories'));
	}
	
	/**
	 * @param UpdateTaskRequest $request
	 * @param Task $task
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
	{
		$this->authorize('update', $task);

		$this->taskService->update($task, $request->validated());

		return redirect()
			->route('tasks.index')
			->with('success', 'Task updated successfully.');
	}
	
	/**
	 * @param Task $task
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function destroy(Task $task): RedirectResponse
	{
		$this->authorize('delete', $task);

		$this->taskService->delete($task);

		return redirect()
			->route('tasks.index')
			->with('success', 'Task deleted successfully.');
	}
	
	/**
	 * @param Task $task
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function toggleStatus(Task $task): RedirectResponse
	{
		$this->authorize('update', $task);

		$this->taskService->toggleStatus($task);

		return back()->with('success', 'Task status updated.');
	}
	
	/**
	 * @param int $id
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function restore(int $id): RedirectResponse
	{
		$task = Task::withTrashed()->findOrFail($id);

		$this->authorize('restore', $task);

		$task->restore();

		return back()->with('success', 'Task restored successfully.');
	}
}
