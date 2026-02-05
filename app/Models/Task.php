<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Task
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $description
 * @property string $priority
 * @property string $status
 * @property Carbon|null $deadline
 * @property Carbon|null $completed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @property-read Category|null $category
 */
class Task extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'category_id',
		'title',
		'description',
		'priority',
		'status',
		'deadline',
		'completed_at',
	];

	/**
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'deadline' => 'datetime',
			'completed_at' => 'datetime',
		];
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	/**
	 * @param Builder $query
	 * @param int $userId
	 * @return Builder
	 */
	public function scopeForUser(Builder $query, int $userId): Builder
	{
		return $query->where('user_id', $userId);
	}

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopePending(Builder $query): Builder
	{
		return $query->where('status', 'pending');
	}

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeInProgress(Builder $query): Builder
	{
		return $query->where('status', 'in_progress');
	}

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeCompleted(Builder $query): Builder
	{
		return $query->where('status', 'completed');
	}

	/**
	 * @param Builder $query
	 * @return Builder
	 */
	public function scopeOverdue(Builder $query): Builder
	{
		return $query->where('deadline', '<', now())
			->where('status', '!=', 'completed');
	}

	/**
	 * @param Builder $query
	 * @param string $priority
	 * @return Builder
	 */
	public function scopeByPriority(Builder $query, string $priority): Builder
	{
		return $query->where('priority', $priority);
	}

	/**
	 * @param Builder $query
	 * @param int $categoryId
	 * @return Builder
	 */
	public function scopeByCategory(Builder $query, int $categoryId): Builder
	{
		return $query->where('category_id', $categoryId);
	}

	/**
	 * @param Builder $query
	 * @param int $days
	 * @return Builder
	 */
	public function scopeUpcoming(Builder $query, int $days = 7): Builder
	{
		return $query->whereBetween('deadline', [now(), now()->addDays($days)])
			->where('status', '!=', 'completed');
	}
}
