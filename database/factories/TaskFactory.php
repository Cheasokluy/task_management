<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;
    public function definition(): array
    {
        $user = User::all()->random();
        $status = $this->faker->randomElement(['in-progress', 'completed']);
        $completedAt = $status === 'completed' ? Carbon::now()->subMonth(rand(1, 12)) : null;
        return [
        //     'title' => $this->faker->sentence,
        //     'description' => $this->faker->paragraph,
        //     'status' => 'pending', // Set status to pending
        //     'user_id' => null, // Set user_id to null
        //     'due_date' => $this->faker->date,
        // ];
        'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $status,
            'user_id' => $user->id,
            'due_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31'),
            'completed_at' => $completedAt,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            UserTask::create([
                'user_id' => $task->user_id,
                'task_id' => $task->id,
            ]);
        });
    }
}
