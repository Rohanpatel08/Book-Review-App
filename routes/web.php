<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('book/{id}', [DashboardController::class, 'details'])->name('book.details');
Route::post('book/save-review', [DashboardController::class, 'saveReview'])->name('book.savereview');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerProcess'])->name('auth.register');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginProcess'])->name('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('auth.index');
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('update.profile');
    Route::get('change/password', [ProfileController::class, 'changePassword'])->name('auth.changePassword');
    Route::post('store/password', [ProfileController::class, 'storePassword'])->name('storePassword');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'isAdmin'], function () {

        Route::resource('books', BookController::class);

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/edit/{id}', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::post('reviews/update/{id}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::post('reviews/delete', [ReviewController::class, 'delete'])->name('reviews.delete');
    });


    Route::get('my-reviews', [ReviewController::class, 'my_reviews'])->name('userReviews');
    Route::get('my-reviews/edit/{id}', [ReviewController::class, 'my_reviewsEdit'])->name('userReviews.edit');
    Route::post('my-reviews/update/{id}', [ReviewController::class, 'my_reviewUpdate'])->name('userReviews.update');
    Route::post('my-reviews/delete', [ReviewController::class, 'my_reviewDelete'])->name('userReviews.delete');

    Route::get('verify/email/', [ProfileController::class, 'verifyEmail'])->name('verification.notice');
    Route::get('verify/email/{id}/{hash}', [ProfileController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [ProfileController::class, 'resendEmail'])->middleware('throttle:6,1')->name('verification.send');
});
