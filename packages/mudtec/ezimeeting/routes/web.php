<?php

use Illuminate\Support\Facades\Route;

use Mudtec\Ezimeeting\Http\Middleware\RedirectToEzimeeting;



/*
Route::middleware([RedirectToEzimeeting::class])->group(function () {
    Route::get('/corporation/register', [HomeController::class, 'home'])->name('ezimeetingHome');
});
*/




use Mudtec\Ezimeeting\Http\Controllers\HomeController as HomeController;
Route::get('/home', [HomeController::class, 'index'])->name('ezihome');

use Mudtec\Ezimeeting\Http\Controllers\MailController as MailController;
Route::post('/approve-request/{userid}/{corpid}', [MailController::class, 'approve'])->name('approveRequest');
Route::post('/reject-request/{userid}/{corpid}', [MailController::class, 'reject'])->name('rejectRequest');

use Mudtec\Ezimeeting\Http\Middleware\CheckCorporationMembership;
use Mudtec\Ezimeeting\Http\Controllers\RegisterController as RegisterController;
Route::middleware([CheckCorporationMembership::class])->group(function () {
    
});

use Mudtec\Ezimeeting\Http\Controllers\AdminController as AdminController;
use Mudtec\Ezimeeting\Http\Controllers\CorporationController as CorporationController;
use Mudtec\Ezimeeting\Http\Controllers\DepartmentController as DepartmentController;
use Mudtec\Ezimeeting\Http\Controllers\CorpuserController as CorpuserController;
use Mudtec\Ezimeeting\Http\Controllers\RoleController as RoleController;
use Mudtec\Ezimeeting\Http\Controllers\MeetingController as MeetingController;
Route::middleware('web')->group(function () { 
     
    Route::get('/eziMeeting', [HomeController::class, 'index'])->name('home');

    Route::get('/eziMeeting/underDevelopment', function () {
        return view('ezimeeting::underDevelopment');
    })->name('underDevelopment');
    
    Route::get('/eziMeeting/corporation/register', [RegisterController::class, 'register'])->name('corporationRegister');

    Route::get('/eziMeeting/admin/corporations', [CorporationController::class, 'corporations'])->name('corporations');
    Route::get('/eziMeeting/admin/corporations/create', [CorporationController::class, 'create'])->name('corporationsCreate');
    Route::get('/eziMeeting/admin/corporations/update/{corporation}', [CorporationController::class, 'update'])->name('corporationsUpdate');
    Route::get('/eziMeeting/admin/corporations/users', [CorporationController::class, 'users'])->name('corporationsUser');

    Route::get('/eziMeeting/admin/departments', [DepartmentController::class, 'corporations'])->name('corpDepartments');
    Route::get('/eziMeeting/admin/departments/{corporation}', [DepartmentController::class, 'departments'])->name('departments');
    Route::get('/eziMeeting/admin/departments/{corporation}/create', [DepartmentController::class, 'create'])->name('departmentCreate');
    Route::get('/eziMeeting/admin/departments/{corporation}/update/{department}', [DepartmentController::class, 'update'])->name('departmentUpdate');
    Route::get('/eziMeeting/admin/department/managers', [DepartmentController::class, 'manager'])->name('departmentManagers');

    Route::get('/eziMeeting/admin/users', [CorpuserController::class, 'list'])->name('corpUsers');
    Route::get('/eziMeeting/admin/users/{user}', [CorpuserController::class, 'edit'])->name('corpUserEdit');

    Route::get('/eziMeeting/admin/meeting/status/manager', [AdminController::class, 'meetingstatus'])->name('meetingStatus');
    Route::get('/eziMeeting/admin/meeting/interval/manager', [AdminController::class, 'meetinginterval'])->name('meetingInterval');
    Route::get('/eziMeeting/admin/meeting/location/manager', [AdminController::class, 'meetinglocation'])->name('meetingLocation');

    Route::get('/eziMeeting/admin/meeting/delegate/role/manager', [AdminController::class, 'meetingdelegaterole'])->name('meetingDelegateRole');
    Route::get('/eziMeeting/admin/meeting/attendee/status/manager', [AdminController::class, 'meetingattendeestatus'])->name('meetingAttendeeStatus');
    Route::get('/eziMeeting/admin/meeting/minute/action/status/manager', [AdminController::class, 'meetingminuteactionstatus'])->name('meetingMinuteActionStatus');

    Route::get('/eziMeeting/admin/roles', [RoleController::class, 'roles'])->name('roles');
    Route::get('/eziMeeting/admin/role/create', [RoleController::class, 'create'])->name('roleCreate');
    Route::get('/eziMeeting/admin/role/{role}', [RoleController::class, 'role'])->name('roleUpdate');

    Route::get('/eziMeeting/meeting/owner/list', [MeetingController::class, 'ownerList'])->name('myMeetingList');


    Route::get('/eziMeeting/meeting/new', [MeetingController::class, 'new'])->name('newMeeting');
    Route::get('/eziMeeting/meeting/new/delegates/{corpId}/{meetingId}', [MeetingController::class, 'delegates'])->name('newMeetingDelegates');
    Route::get('/eziMeeting/meeting/list', [MeetingController::class, 'list'])->name('meetingList');

    Route::get('/eziMeeting/meeting/view/{meeting}', [MeetingController::class, 'view'])->name('meetingView');
    Route::get('/eziMeeting/meeting/edit/{meeting}', [MeetingController::class, 'edit'])->name('meetingEdit');

    Route::get('/eziMeeting/meeting/{meeting}/minutes', [MeetingController::class, 'MinutesList'])->name('MeetingMinuteList');

    Route::get('/eziMeeting/meeting/{meeting}/minute', [MeetingController::class, 'MinutesDetail'])->name('MeetingMinuteDetails');
    Route::get('/eziMeeting/meeting/{meeting}/minute/{minute}', [MeetingController::class, 'viewMinutes'])->name('viewMeetingMinutes');

    Route::get('/eziMeeting/about', [HomeController::class, 'about'])->name('about');
    Route::get('/eziMeeting/cantact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/eziMeeting/contact/send', [HomeController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/eziMeeting/terms', [HomeController::class, 'terms'])->name('terms');
    Route::get('/eziMeeting/terms', [HomeController::class, 'terms'])->name('terms');
    //Route::get('/eziMeeting/faq', [HomeController::class, 'faq'])->name('faq');

});


