<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ProgramHeadController;
use App\Http\Controllers\SemestersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\AllumniController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Auth\ResetPasswordController;
use Auth\ForgotPasswordController;
Route::get('/clear-cache',function(){
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});
Route::get('/', [LoginController::class,'showLoginForm'])->name('login');
Route::get('/choose',[App\Http\Controllers\AuthorizeController::class,'choose'])->name('choose');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::post('/userlogin',[LoginController::class, 'login'])->name('userlogin');
Route::post('/userregister',[RegisterController::class, 'sample'])->name('userregister');
Route::get('/welcome',function(){ return view('incomingstudents.welcome'); });
Route::get('/search',function(){ return view('incomingstudents.search'); });

Route::get('ajaxIndex', [StudentsController::class, 'ajaxIndex'])->name('ajaxIndex');
Route::get('ajaxAssigned', [StudentsController::class, 'ajaxAssigned'])->name('ajaxAssigned');
Route::get('/viewStudent/{id}',[StudentsController::class,'viewStudent'])->name('viewStudent');
Route::get('/checkRequirements/{id}',[StudentsController::class,'checkRequirements'])->name('checkRequirements');

Route::post('/getGrade',[StudentsController::class, 'getGrade'])->name('getGrade');
Route::post('/upl_stud_csv',[StudentsController::class, 'uploadStudent'])->name('stud_csv');


Route::get('/reset',[App\Http\Controllers\AuthorizeController::class,'showchangepass'])->name('reset');
Route::resource('/enroll', IncomingStudentsController::class);
Route::controller(AllumniController::class)->group(function(){
    Route::post('/Province','returnProvince')->name('getProv');
    Route::post('/City','returnCity')->name('getCity');
    Route::post('/Barangay','returnBrgy')->name('getBrgy');
    Route::post('/injob','insertJob')->name('injob');
});
Route::controller(IncomingStudentsController::class)->group(function(){
    Route::post('/upreq','uploadreq')->name('uploadreq');
    Route::post('/searchTicket','searchticket');
    Route::get('/studentform/{type}','studentform')->name('studentform');
    Route::post('/stop','StopNum')->name('stop');
    Route::post('/getnum','GetNum')->name('getnum');
    Route::post('/acceptConsent','accept')->name('acceptConsent');
    Route::post('/storeStud','store')->name('studIn');
    Route::post('/storeStudent','storeStudent')->name('storestudent');
});

Route::controller(ResetPasswordController::class)->group(function(){
    Route::post('/verifypass','verify')->name('password.verify');
    Route::post('/resetinfo','changeinfo')->name('changeinfo');
    Route::get('/password/reset/{token}','showResetForm')->name('password.reset');
    Route::post('/password/reset','reset')->name('password.update');
});

Route::controller(ForgotPasswordController::class)->group(function(){
    Route::get('/password/reset','showLinkRequestForm')->name('password.request');
    Route::post('/password/email','sendResetLinkEmail')->name('password.email');
});
Route::resource('/{request}',AuthorizeController::class);
// Route::post('/upreq',[IncomingStudentsController::class, 'uploadreq'])->name('uploadreq');
// Route::post('/searchTicket',[IncomingStudentsController::class, 'searchticket']);
// Route::get('/studentform/{type}',[IncomingStudentsController::class,'studentform'])->name('studentform');
// Route::post('/stop',[IncomingStudentsController::class,'StopNum'])->name('stop');
// Route::post('/getnum',[IncomingStudentsController::class,'GetNum'])->name("getnum");

// Route::get('/sample',[IncomingStudentsController::class, 'showView']);
// Route::group(['middleware'=> 'auth'], function(){
	// Route::get('auth/{type}',[AuthorizeController::class, 'index']);
// });
// Auth::routes();
// Route::resource('/admin', 'HomeController')->name('dashboard');
// Route::post('/home', 'App\Http\Controllers\HomeController@add')->name('dashboard.add');

//  Route::group(['middleware' => 'auth'], function () {
// 	Route::resource('incoming/incoming-students', IncomingStudentsController::class);
// 	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
// 	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
// 	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
// 	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
// 	Route::resource('/semesters', SemestersController::class);
// 	Route::resource('/students', StudentsController::class);
// 	Route::resource('/employees', EmployeesController::class);
// 	Route::resource('/program-head', ProgramHeadController::class);
// 	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
// });
