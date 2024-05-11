<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[RegisterController::class, 'store']);

Route::post('/login',[LoginController::class, 'check']);


Route::get('tasks', [Taskcontroller::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::get('tasks/create', [Taskcontroller::class, 'create'])->name('tasks.create');
Route::get('tasks/{id}/edit', [Taskcontroller::class, 'edit'])->name('tasks.edit');
// In routes/api.php

Route::put('tasks/{id}/update', [Taskcontroller::class, 'update'])->name('tasks.update');


Route::delete('tasks/{task}', [Taskcontroller::class, 'destroy'])->name('tasks.destroy');

Route::get('tasks/{id}', [TaskController::class, 'show']);


