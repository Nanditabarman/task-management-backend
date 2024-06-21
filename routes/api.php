<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/authuser', function (Request $request) {
    return $request->user();
});

Route::get('tasks', [Taskcontroller::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::get('tasks/create', [Taskcontroller::class, 'create'])->name('tasks.create');
Route::get('tasks/{id}/edit', [Taskcontroller::class, 'edit'])->name('tasks.edit');
// In routes/api.php

Route::put('tasks/{id}/update', [Taskcontroller::class, 'update'])->name('tasks.update');
Route::delete('tasks/{task}', [Taskcontroller::class, 'destroy'])->name('tasks.destroy');
Route::get('tasks/{id}', [TaskController::class, 'show']);

Route::post('tasks/{taskId}/status', [TaskController::class, 'updateStatus']);
Route::get('/task-statuses', [TaskController::class, 'getStatuses']);


Route::apiResource('employees', EmployeeController::class);
