<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use Inertia\Inertia;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\MuscleGroupController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\WorkoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(RouteServiceProvider::HOME);
})->name('dashboard');

Route::resources([
    'workouts' => WorkoutController::class,
    'logs' => LogController::class,
    'equipment' => EquipmentController::class,
    'sets' => SetController::class,
    'exercises' => ExerciseController::class,
]);

Route::resource('muscles', MuscleController::class)->only([
    'index', 'show'
]);

Route::resource('groups', MuscleGroupController::class)->only([
    'index', 'show'
]);

Route::patch('/log/reorder', [LogController::class, 'reorder'])->name('logs.reorder');

Route::patch('/log/{log}/type', [LogController::class, 'updateType'])->name('logs.update.type');

Route::resource('workouts', WorkoutController::class)->names([
    'index' => 'workouts.list',
    'show' => 'workouts.show',
    'update' => 'workouts.update',
    'store' => 'workouts.store'
]);

Route::resource('exercises', ExerciseController::class)->names([
    'index' => 'exercises.list',
    'show' => 'exercises.show',
    'update' => 'exercises.update',
    'store' => 'exercises.store'
]);

Route::resource('logs', LogController::class)->names([
    'store' => 'logs.store',
    'show' => 'logs.show',
    'update' => 'logs.update',
    'destroy' => 'logs.destroy'
]);

Route::resource('sets', SetController::class)->names([
    'destroy' => 'sets.destroy'
]);

Route::get('/exercise/s', [ExerciseController::class, 'search'])->name('exercise.search');
Route::post('/exercises/add', [ExerciseController::class, 'store_quick'])->name('exercises.store.quick');

Route::post('/exercises/{exercise}/equipment/{equipment}', [ExerciseController::class, 'attach_equipment']);
Route::delete('/exercises/{exercise}/equipment/{equipment}', [ExerciseController::class, 'detach_equipment']);
Route::post('/exercises/{exercise}/muscle/{muscle}', [ExerciseController::class, 'attach_muscle']);
Route::delete('/exercises/{exercise}/muscle/{muscle}', [ExerciseController::class, 'detach_muscle']);

Route::post('/workouts/{workout}/note', [WorkoutController::class, 'store_note'])->name('workouts.note.store');






