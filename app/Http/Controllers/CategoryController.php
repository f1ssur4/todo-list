<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$categories = $request->user()
			->categories()
			->withCount('tasks')
			->get();

		return view('categories.index', compact('categories'));
	}

	/**
	 * @return View
	 */
	public function create(): View
	{
		return view('categories.create');
	}

	/**
	 * @param StoreCategoryRequest $request
	 * @return RedirectResponse
	 */
	public function store(StoreCategoryRequest $request): RedirectResponse
	{
		$request->user()->categories()->create($request->validated());

		return redirect()
			->route('categories.index')
			->with('success', 'Category created successfully.');
	}

	/**
	 * @param Category $category
	 * @return View
	 * @throws AuthorizationException
	 */
	public function edit(Category $category): View
	{
		$this->authorize('update', $category);

		return view('categories.edit', compact('category'));
	}
	
	/**
	 * @param UpdateCategoryRequest $request
	 * @param Category $category
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
	{
		$this->authorize('update', $category);

		$category->update($request->validated());

		return redirect()
			->route('categories.index')
			->with('success', 'Category updated successfully.');
	}
	
	/**
	 * @param Category $category
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function destroy(Category $category): RedirectResponse
	{
		$this->authorize('delete', $category);

		$category->delete();

		return redirect()
			->route('categories.index')
			->with('success', 'Category deleted successfully.');
	}
}
