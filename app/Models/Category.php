<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Category
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @property-read Collection<int, Task> $tasks
 */
class Category extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'name',
		'color',
	];

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return HasMany
	 */
	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class);
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
}
