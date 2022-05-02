<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoleController;


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


Route::middleware(['auth:sanctum'])->group(function () {
});

// Login Route

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

// Role Route

Route::get('role', [RoleController::class, 'all']);
Route::post('role', [RoleController::class, 'create']);
Route::patch('role/{id}', [RoleController::class, 'update']);
Route::delete('role/{id}', [RoleController::class, 'delete']);