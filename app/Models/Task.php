<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status', 'user_id', 'due_date','progress'];

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
