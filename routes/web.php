<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Middleware\auth;
use App\Http\Controllers\HrController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CandidateController;

Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});


Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware(['role.session:hr'])->group(function () {

    // Route::get('/hr/dashboard', function () {
    //     return view('index');
    // })->name('hr.dashboard');
    Route::get('/hr/dashboard', [HrController::class, 'index_show'])
        ->name('hr.dashboard');
    Route::get('/hr/chatbox', [HrController::class, 'chatbox_show'])
        ->name('hr.chatbox');
    Route::get('/hr/intern-create', [HrController::class, 'internCreate_show'])
        ->name('hr.intern.create');
    Route::get('/hr/intern-list', [HrController::class, 'internList_show'])
        ->name('hr.internship.list');
    Route::post('/hr/internship/store', [HrController::class, 'internship_store'])
        ->name('internship.store');
    Route::get('/hr/get-districts', [HrController::class, 'getDistricts'])
        ->name('get.districts');
    Route::get('/hr/get-cities', [HrController::class, 'getCities'])
        ->name('get.cities');
    Route::post('/hr/intern/status-update', [HrController::class, 'updateStatus'])
        ->name('intern.status.update');
    Route::get('/hr/intern/view/{id}', [HrController::class, 'inter_view'])
        ->name('intern.view');
    Route::get('/hr/intern/{id}/edit', [HrController::class, 'intern_edit_show'])
        ->name('intern.edit');
    Route::put('/hr/internship/{id}', [HrController::class, 'intern_update'])
        ->name('internship.update');
    Route::get('/hr/get-cities', [HrController::class, 'getCities'])
        ->name('get.cities');
    Route::get('/hr/mentor-create', [HrController::class, 'mentorCreate_show'])
        ->name('hr.mentor.create');
    Route::post('/hr/mentor/store', [HrController::class, 'mentor_store'])
        ->name('mentor.store');
    Route::get('/hr/mentor-list', [HrController::class, 'mentorList_show'])
        ->name('hr.mentor.list');
    Route::post('/hr/mentor/status-update', [HrController::class, 'updateStatus_mentor'])
        ->name('mentor.status.update');
    Route::get('/hr/mentor/view/{id}', [HrController::class, 'mentor_view'])
        ->name('mentor.view');
    Route::get('/hr/mentor/{id}/edit', [HrController::class, 'mentor_edit_show'])
        ->name('mentor.edit');
    Route::put('/hr/mentor/{id}', [HrController::class, 'mentor_update'])
        ->name('mentor.update');
    Route::get('/hr/assign', [HrController::class, 'assignCreate_show'])
        ->name('hr.assign.create');
    Route::post('/hr/assign/create', [HrController::class, 'assignCreate'])
        ->name('assign.store');
    Route::get('/hr/assign-list', [HrController::class, 'assignList_show'])
        ->name('hr.assign.list');
    Route::post('/hr/assign/status-update', [HrController::class, 'updateStatus_assign'])
        ->name('assign.status.update');
    Route::get('/hr/assign/view/{id}', [HrController::class, 'assign_view'])
        ->name('assign.view');
    Route::get('/hr/get-designations', [HrController::class, 'getDesignations'])
        ->name('get.designations');
    Route::get('/hr/department', [HrController::class, 'department_show'])
        ->name('hr.department.list');
    Route::get('/hr/department/create', [HrController::class, 'department_create'])
        ->name('hr.department.create');
    Route::post('/hr/department/create', [HrController::class, 'department_store'])
        ->name('hr.departments.store');
    Route::get('/hr/designation/create', [HrController::class, 'designation_create'])
        ->name('hr.designation.create');
    Route::post('/hr/designation/create', [HrController::class, 'designation_store'])
        ->name('hr.designation.store');
    Route::get('hr/designation/{id}/edit', [HrController::class, 'department_edit'])
        ->name('hr.department.edit');
    Route::put('/hr/department/{id}/update', [HrController::class, 'updateDesignations'])
        ->name('department.update');
    Route::delete('/designation/{id}', [HrController::class, 'designation_destroy'])
        ->name('designation.delete');
    Route::post(
        '/designation/status-update',
        [HrController::class, 'designation_statusUpdate']
    )->name('designation.status.update');
    Route::get('/hr/completed_project', [HrController::class, 'completed_project_show'])
        ->name('hr.completed_project.list');
    Route::get(
        '/certificate/generate/{id}',
        [HrController::class, 'generate_cirtificate']
    )->name('certificate.generate');



    Route::get('/hr/birthday_list', [HrController::class, 'upcomming_birthday_show'])
        ->name('hr.birthday.list');
    Route::get('/hr/work-anniversery-list', [HrController::class, 'upcomming_work_anniversery_show'])
        ->name('hr.work_anniversery.list');


Route::get('/chat', [HrController::class, 'chatbox_show'])->name('chat');
Route::get('/chat/messages/{user}', [HrController::class, 'messages'])->name('chat.messages');
Route::post('/chat/send', [HrController::class, 'send'])->name('chat.send');
Route::get('/chat/users', [HrController::class, 'chatUsers']);});



Route::middleware('role.session:mentor')->group(
    function () {

        Route::get('/mentor/dashboard', [MentorController::class, 'index_show'])
            ->name('mentor.dashboard');

        Route::get('/mentor/intern-list', [MentorController::class, 'mentor_internList_show'])
            ->name('mentor.intern.list');
        Route::get('/mentor/assignment/create', [MentorController::class, 'assignCreate'])
            ->name('mentor.assign.create');
        Route::post('/mentor/assignment/store', [MentorController::class, 'assign_store'])
            ->name('assignment.store');
        Route::get('/mentor/assignment/{id}', [MentorController::class, 'assign_view'])
            ->name('assignment.view');
        Route::get('/mentor/assignment/{id}/edit', [MentorController::class, 'assignment_edit_show'])
            ->name('assignment.edit');
        Route::put('/mentor/assignment/{id}', [MentorController::class, 'assign_update'])
            ->name('assignment.update');

        Route::get('/mentor/intern/profile/{id}', [MentorController::class, 'intern_profile'])
            ->name('intern.profile');
        Route::get('/assignment-mentor/{id}/notes', [MentorController::class, 'getNotes']);


        Route::get('/mentor/submission-assignment/{id}', [MentorController::class, 'submission_assigment_show'])
            ->name('submition_assignment.show');

        Route::post('/submit-review', [MentorController::class, 'store']);
        Route::get('/get-reviews/{project}', [MentorController::class, 'getReviews']);

        Route::get('/mentor/profile', [MentorController::class, 'mentor_profile_show'])->name('profile.show');
    }
);

Route::middleware('role.session:candidate')->group(
    function () {

        Route::get('/candidate/dashboard', [CandidateController::class, 'index_show'])
            ->name('candidate.dashboard');

        Route::get('/candidate/projects', [CandidateController::class, 'projectList_show'])
            ->name('candidate.project.list');

        Route::post('/candidate/assignment/{id}/submit', [CandidateController::class, 'submitAssignmentPost'])
            ->name('assignment.submit.post');
        Route::post('/candidate/assignment-note/store', [CandidateController::class, 'today_work_store'])
            ->name('assignment.note.store');


        Route::post('/candidate/github-link/store', [CandidateController::class, 'github_store'])
            ->name('assignment.github.store');
        Route::get('/candidate/submited-project', [CandidateController::class, 'submitedprojectList_show'])
            ->name('candidate.project.submitted');

        Route::get('/assignment/{id}/notes', [CandidateController::class, 'getNotes']);


        Route::get('/profile/id-card', [CandidateController::class, 'showIdCard'])
            ->name('profile.idcard');


        Route::get('/candodate/profile', [CandidateController::class, 'candidate_profile_show'])->name('candidate.profile.show');
    }

);