<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'assinged_by',
        'assigned_to',
    ];
    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_assignments', 'task_id', 'employee_id');
    }

    public function statuses()
{
    return $this->hasMany(TaskStatus::class);
}



}
