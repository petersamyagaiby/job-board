<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobPostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;

Auth::routes();

Route::middleware(['auth', 'checkUserType:candidate'])->group(function () {
    Route::get('/candidate/profile', [CandidateController::class, 'index'])->name('candidate.profile');

    Route::resource('candidate', CandidateController::class);
});

Route::middleware(['auth', 'checkUserType:company'])->group(function () {
    Route::get('/company/profile', [CompanyController::class, 'index'])->name('company.profile');

    Route::get('/company/jobs', [CompanyController::class, 'allJobs'])->name('company.jobs');

    Route::resource('company', CompanyController::class);
});

Auth::routes();

Route::get('/', [JobPostsController::class, 'index'])->name('homepage');

Route::get('/jobs/search', [JobPostsController::class, 'search'])->name('jobs.search');

Route::get('/jobs/filter', [JobPostsController::class, 'filter'])->name('jobs.filter');

Route::get('/jobs/trashed', [JobPostsController::class, 'trashed'])->name('jobs.trashed');

Route::get('/jobs/{id}/restore', [JobPostsController::class, 'restore'])->name('jobs.restore');

Route::delete('/jobs/{job}/forceDelete', [JobPostsController::class, 'forceDelete'])->name('jobs.forceDelete');

Route::get('/jobs/{job}/applications', [JobPostsController::class, 'applications'])->name('jobs.applications');

Route::resource('/jobs', JobPostsController::class);

Route::resource('/application', ApplicationController::class);

Route::get('/application/{application}/accept', [JobPostsController::class, 'accept'])->name('application.accept');

Route::get('/application/{application}/reject', [JobPostsController::class, 'reject'])->name('application.reject');

Route::get('/application/{application}/review', [JobPostsController::class, 'review'])->name('application.review');

Route::resource('/comment', CommentController::class);
