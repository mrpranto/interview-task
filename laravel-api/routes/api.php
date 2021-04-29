<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function (Router $router){

    $router->post('login', [AuthController::class, 'login'])->name('user.login');
    $router->post('register', [AuthController::class, 'register'])->name('user.register');

    $router->group(['middleware' => 'auth:sanctum'], function ($router){

        $router->get('/user', function (Request $request) {
            return $request->user()->load('profile', 'role');
        });

        $router->get('users', [UserController::class, 'index'])->name('users.index');
        $router->post('users/{user}/update', [UserController::class, 'update'])->name('users.update');
        $router->get('users/{user}', [UserController::class, 'show'])->name('users.show');
        $router->put('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');

        $router->resource('roles', RoleController::class);

        $router->post('logout', [AuthController::class, 'logout'])->name('user.logout');
    });

});

