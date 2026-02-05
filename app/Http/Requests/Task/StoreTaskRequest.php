<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreTaskRequest
 */
class StoreTaskRequest extends FormRequest
{
	/**
	 * @return bool
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * @return array
	 */
	public function rules(): array
	{
		return [
			'title' => ['required', 'string', 'max:255'],
			'description' => ['nullable', 'string', 'max:10000'],
			'category_id' => [
				'nullable',
				'integer',
				Rule::exists('categories', 'id')->where('user_id', $this->user()->id),
			],
			'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
			'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'completed'])],
			'deadline' => ['nullable', 'date', 'after_or_equal:today'],
		];
	}
}
