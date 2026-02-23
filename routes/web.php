<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Middleware\auth;
use App\Http\Controllers\HrController;
use App\Http\Controllers\MentorController;

Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});


Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['role.session:hr'])->group(function () {

    Route::get('/hr/dashboard', function () {
        return view('index');
    })->name('hr.dashboard');


    Route::get('/intern-create', [HrController::class, 'internCreate_show'])
        ->name('hr.intern.create');
    Route::get('/intern-list', [HrController::class, 'internList_show'])
        ->name('hr.intern.list');
    Route::post('/internship/store', [HrController::class, 'internship_store'])
        ->name('internship.store');
    Route::get('/get-districts', [HrController::class, 'getDistricts'])
        ->name('get.districts');
    Route::get('/get-cities', [HrController::class, 'getCities'])
        ->name('get.cities');
    Route::post('/intern/status-update', [HrController::class, 'updateStatus'])
        ->name('intern.status.update');
    Route::get('/intern/view/{id}', [HrController::class, 'inter_view'])
        ->name('intern.view');
    Route::get('/intern/{id}/edit', [HrController::class, 'intern_edit_show'])
        ->name('intern.edit');
    Route::put('/internship/{id}', [HrController::class, 'intern_update'])
        ->name('internship.update');
    Route::get('/get-cities', [HrController::class, 'getCities'])
        ->name('get.cities');
    Route::get('/mentor-create', [HrController::class, 'mentorCreate_show'])
        ->name('hr.mentor.create');
    Route::post('/mentor/store', [HrController::class, 'mentor_store'])
        ->name('mentor.store');
    Route::get('/mentor-list', [HrController::class, 'mentorList_show'])
        ->name('hr.mentor.list');
    Route::post('/mentor/status-update', [HrController::class, 'updateStatus_mentor'])
        ->name('mentor.status.update');
    Route::get('/mentor/view/{id}', [HrController::class, 'mentor_view'])
        ->name('mentor.view');
    Route::get('/mentor/{id}/edit', [HrController::class, 'mentor_edit_show'])
        ->name('mentor.edit');
    Route::put('/mentor/{id}', [HrController::class, 'mentor_update'])
        ->name('mentor.update');
    Route::get('/assign', [HrController::class, 'assignCreate_show'])
        ->name('hr.assign.create');
    Route::post('/assign/create', [HrController::class, 'assignCreate'])
        ->name('assign.store');
    Route::get('/assign-list', [HrController::class, 'assignList_show'])
        ->name('hr.assign.list');
    Route::post('/assign/status-update', [HrController::class, 'updateStatus_assign'])
        ->name('assign.status.update');
    Route::get('/assign/view/{id}', [HrController::class, 'assign_view'])
        ->name('assign.view');
});



Route::middleware('role.session:mentor')->group(
    function () {

        Route::get('/mentor/dashboard', function () {
            return view('mentor.index');
        })->name('mentor.dashboard');
        Route::get('/intern-list', [MentorController::class, 'internList_show'])
            ->name('mentor.intern.list');
        Route::get('/mentor/assignment/create', [MentorController::class, 'assignCreate'])
            ->name('mentor.assign.create');
        Route::post('/assignment/store', [MentorController::class, 'assign_store'])
            ->name('assignment.store');
        Route::get('/assignment/{id}', [MentorController::class, 'assign_view'])
            ->name('assignment.view');
        Route::get('/assignment/{id}/edit', [MentorController::class, 'assignment_edit_show'])
            ->name('assignment.edit');


        Route::put('/assignment/{id}', [MentorController::class, 'assign_update'])
            ->name('assignment.update');
    }
);

Route::middleware('role.session:candidate')->get('/candidate/dashboard', function () {
    return view('candidate.dashboard');
})->name('candidate.dashboard');
