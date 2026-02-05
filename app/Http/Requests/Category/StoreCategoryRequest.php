<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreCategoryRequest
 */
class StoreCategoryRequest extends FormRequest
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
			'name' => [
				'required',
				'string',
				'max:100',
				Rule::unique('categories')
					->where('user_id', $this->user()->id)
					->whereNull('deleted_at'),
			],
			'color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
		];
	}
}
