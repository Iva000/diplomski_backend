<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\MountainController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationEquipmentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/mountains', [MountainController::class, 'index']);

Route::get('/instructors', [InstructorController::class, 'index']);
Route::get('/getInstructorsByStatus/{status}', [InstructorController::class, 'getInstructorsByStatus']);
Route::post('/addInstructor', [InstructorController::class, 'store']);
Route::post('/updateInstructor', [InstructorController::class, 'update']);
Route::post('/loginInstructor', [InstructorController::class, 'login']);
Route::post('/logoutInstructor', [InstructorController::class, 'logout']);
Route::get('/getInstructor/{id}', [InstructorController::class, 'getInstructor']);

Route::get('/equipments', [EquipmentController::class, 'index']);

Route::post('/registerNewUser', [UserController::class, 'register']);
Route::post('/updateUser', [UserController::class, 'update']);
Route::post('/loginUser', [UserController::class, 'login']);
Route::post('/logoutUser', [UserController::class, 'logout']);
Route::get('/getUser/{id}', [UserController::class, 'getUser']);

Route::get('/getClass/{id}', [PeriodController::class, 'index']);
Route::post('/addNewClass', [PeriodController::class, 'createPeriods']);
Route::post('/updateClass', [PeriodController::class, 'update']);

Route::get('/getUsersReservations/{id}/{status}', [ReservationController::class, 'getFromUser']);
Route::get('/getPreviousUsersReservations/{id}', [ReservationController::class, 'getPreviousFromUser']);
Route::get('/getInstructorsReservations/{id}/{status}', [ReservationController::class, 'getFromInstructor']);
Route::get('/getSchedule/{id}', [ReservationController::class, 'getSchedule']);
Route::post('/makeReservation', [ReservationController::class, 'add']);
Route::post('/updateReservation', [ReservationController::class, 'update']);

Route::post('/makeEquipmentReservation', [ReservationEquipmentController::class, 'addReservationEquipment']);
Route::get('/getEquipmentReservation/{id}', [ReservationEquipmentController::class, 'getReservationEquipment']);
