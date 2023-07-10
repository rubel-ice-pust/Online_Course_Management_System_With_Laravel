<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PhotoController;












Route::get('/',[HomeController::class,'HomeIndex'])->middleware('LoginCheck');
Route::get('/visitor',[VisitorController::class,'VisitorIndex'])->middleware('LoginCheck');

//Admin Pannel service management
Route::get('/service',[ServiceController::class,'ServiceIndex'])->middleware('LoginCheck');
Route::get('/getServicesData',[ServiceController::class,'getServiceData'])->middleware('LoginCheck');
Route::post('/ServiceDelete',[ServiceController::class,'ServiceDelete'])->middleware('LoginCheck');
Route::post('/ServiceDetails',[ServiceController::class,'getServiceDetails'])->middleware('LoginCheck');
Route::post('/ServiceUpdate',[ServiceController::class,'ServiceUpdate'])->middleware('LoginCheck');
Route::post('/ServiceAdd',[ServiceController::class,'ServiceAdd'])->middleware('LoginCheck');




//Admin Panel Courses managment
Route::get('/courses',[CoursesController::class,'CoursesIndex'])->middleware('LoginCheck');
Route::get('/getcoursesData',[CoursesController::class,'getCoursesData'])->middleware('LoginCheck');
Route::post('/coursesDelete',[CoursesController::class,'CoursesDelete'])->middleware('LoginCheck');
Route::post('/coursesDetails',[CoursesController::class,'getCoursesDetails'])->middleware('LoginCheck');
Route::post('/coursesUpdate',[CoursesController::class,'CoursesUpdate'])->middleware('LoginCheck');
Route::post('/coursesAdd',[CoursesController::class,'CoursesAdd'])->middleware('LoginCheck');


//Admin Panel Project managment
Route::get('/Project',[ProjectController::class,'ProjectIndex'])->middleware('LoginCheck');
Route::get('/getProjectData',[ProjectController::class,'getProjectData'])->middleware('LoginCheck');
Route::post('/ProjectDelete',[ProjectController::class,'ProjectDelete'])->middleware('LoginCheck');
Route::post('/ProjectDetails',[ProjectController::class,'getProjectDetails'])->middleware('LoginCheck');
Route::post('/ProjectUpdate',[ProjectController::class,'ProjectUpdate'])->middleware('LoginCheck');
Route::post('/ProjectAdd',[ProjectController::class,'ProjectAdd'])->middleware('LoginCheck');


//Admin Panel Contact managment
Route::get('/Contact',[ContactController::class,'ContactIndex'])->middleware('LoginCheck');
Route::get('/getContactData',[ContactController::class,'getContactData'])->middleware('LoginCheck');
Route::post('/ContactDelete',[ContactController::class,'ContactDelete'])->middleware('LoginCheck');
Route::post('/ContactDetails',[ContactController::class,'getContactDetails'])->middleware('LoginCheck');

//Admin Review  managment
Route::get('/Review',[ReviewController::class,'ReviewIndex'])->middleware('LoginCheck');
Route::get('/getReviewData',[ReviewController::class,'getReviewData'])->middleware('LoginCheck');
Route::post('/ReviewDelete',[ReviewController::class,'ReviewDelete'])->middleware('LoginCheck');
Route::post('/ReviewDetails',[ReviewController::class,'getReviewDetails'])->middleware('LoginCheck');
Route::post('/ReviewUpdate',[ReviewController::class,'ReviewUpdate'])->middleware('LoginCheck');
Route::post('/ReviewAdd',[ReviewController::class,'ReviewAdd'])->middleware('LoginCheck');


//LogIn Management

Route::get('/Login',[LoginController::class,'LoginIndex']);
Route::post('/onLogin',[LoginController::class,'onLogin']);
Route::get('/Logout',[LoginController::class,'onLogout']);


//Admin Photo Galllery

Route::get('/Photo',[PhotoController::class,'PhotoIndex'])->middleware('LoginCheck');
Route::post('/PhotoUpload',[PhotoController::class,'PhotoUpload'])->middleware('LoginCheck');
Route::get('/PhotoJSON',[PhotoController::class,'PhotoJSON'])->middleware('LoginCheck');
Route::get('/PhotoJSONByID/{id}',[PhotoController::class,'PhotoJSONByID'])->middleware('LoginCheck');
Route::post('/PhotoDelete', [PhotoController::class,'PhotoDelete'])->middleware('LoginCheck');














