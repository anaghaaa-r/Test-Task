<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');



// // register
// Route::view('/register', 'auth.register')->name('register');

// Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


// login
Route::view('/login', 'auth.login')->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


// authenticated

Route::middleware('auth')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard (common for everyone)
    Route::view('/dashboard', 'auth.dashboard')->name('dashboard');

    // task list
    Route::get('/task/list', [TaskController::class, 'list'])->name('task.list');

    // for authenticated admins
    Route::middleware('admin')->group(function () {

        // add user
        Route::view('/user/create', 'admin.user-add')->name('user.add');
        Route::post('/user/create', [UserController::class, 'addUser'])->name('user.submit');

        // users list
        Route::get('/user/list', [UserController::class, 'list'])->name('user.list');


        // list categories
        Route::get('/category', [CategoryController::class, 'list'])->name('category.list');

        // create and update categories
        Route::post('/category/save/{id?}', [CategoryController::class, 'save'])->name('category.save');

        // delete category
        Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');


        // task add
        Route::view('/task/add', 'task.task-add')->name('task.add');
        Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');

        // update task
        Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
        Route::post('/task/update/{id}', [TaskController::class, 'update'])->name('task.update');

        // delete task
        Route::delete('/task/delete/{id}', [TaskController::class, 'delete'])->name('task.delete');

    });


    // for authenticated users
    Route::middleware('user')->group(function () {

    //    task by user
    Route::get('/task/user', [TaskController::class, 'userTasks'])->name('task.users');

    });


});

