<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskAssignment;
use App\Models\User;
use App\Mail\TaskAssigned;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['employees', 'statuses'])->get();
        return response()->json(['tasks' => $tasks]);
    }


    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'deadline' => 'required|date',
            'assigned_to' => 'required|exists:employees,id',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'assigned_by' => Auth::id(),
            'assigned_to' => $validated['assigned_to'],
        ]);

        TaskAssignment::create([
            'task_id' => $task->id,
            'employee_id' => $validated['assigned_to'],
        ]);

        $employee = \App\Models\Employee::find($validated['assigned_to']);
        Log::info('Sending email to: ' . $employee->email);

        Mail::to($employee->email)->send(new TaskAssigned($task, $employee));

        return response()->json(['task' => $task, 'message' => 'Task created successfully']);
    }

    public function edit($id)
    {
        $task = Task::where('id', $id)->first();
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'sometimes|required',
            'deadline' => 'sometimes|required|date',
            'assigned_to' => 'sometimes|required|exists:employees,id',
        ]);

        $task->update($validated);

        if ($request->has('assigned_to')) {
            TaskAssignment::updateOrCreate(
                ['task_id' => $task->id],
                ['employee_id' => $validated['assigned_to']]
            );
        }

        return response()->json(['task' => $task, 'message' => 'Task updated successfully']);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function show($id)
    {
        $task = Task::with('employees')->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json(['task' => $task]);
    }

    public function getStatuses()
    {
        $statuses = TaskStatus::with(['task', 'employee'])->get();

        return response()->json(['statuses' => $statuses]);
    }

    public function updateStatus(Request $request, $taskId)
    {
        $validated = $request->validate([
            'status' => 'required|in:Not Started,In Progress,Completed',
            'progress' => 'required|integer|between:0,100',
        ]);

        $task = Task::findOrFail($taskId);

        // Update or create the status entry without employee_id
        $status = TaskStatus::updateOrCreate(
            ['task_id' => $taskId],
            [
                'status' => $validated['status'],
                'progress' => $validated['progress'],
            ]
        );

        return response()->json(['status' => $status, 'message' => 'Task status updated successfully']);
    }

}
