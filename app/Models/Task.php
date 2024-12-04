<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status', 'user_id', 'due_date','progress','completed_at'];
    protected $dates = ['due_date', 'completed_at'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($task) {
            TaskActivity::create([
                'task_id' => $task->id,
                'user_id' => $task->user_id,
                'activity' => 'created',
            ]);
        });

        static::updated(function ($task) {
            TaskActivity::create([
                'task_id' => $task->id,
                'user_id' => $task->user_id,
                'activity' => 'updated',
            ]);
        });

        static::deleting(function ($task) {
            TaskActivity::create([
                'task_id' => $task->id,
                'user_id' => $task->user_id,
                'activity' => 'deleted',
            ]);
        });
    }
    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedUser()
    {
        return $this->hasOneThrough(User::class, UserTask::class, 'task_id', 'name', 'id', 'user_id');
    }
}
