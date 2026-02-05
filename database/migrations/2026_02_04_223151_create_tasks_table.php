<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
			$table->string('title', 255);
			$table->text('description')->nullable();
			$table->enum('priority', ['low', 'medium', 'high'])->default('medium');
			$table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
			$table->dateTime('deadline')->nullable();
			$table->dateTime('completed_at')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->index(['user_id', 'status', 'deleted_at']);
			$table->index(['user_id', 'deadline', 'deleted_at']);
			$table->index(['user_id', 'priority', 'deleted_at']);
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('tasks');
	}
};
