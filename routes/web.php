<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/trips/{trip}/edit', [QuestionsController::class, 'editTrip'])->name('trips.edit');

    Route::put('/trips/{trip}', [QuestionsController::class, 'updateTrip'])->name('trips.update');

    Route::delete('/trips/{trip}', [QuestionsController::class, 'destroyTrip'])->name('trips.destroy');

    Route::get('/questions', [QuestionsController::class, 'disaplyQuestions'])->name('questions.display');

    Route::get('/askQuestion', [QuestionsController::class, 'addTrip'])->name('questions.ask');

    Route::post('/storeQuestion', [QuestionsController::class, 'storeTrip'])->name('trip.store');

    Route::get('/questions/{trip}', [QuestionsController::class, 'showTripComments'])->name('trip.comments');

    Route::post('/questions/{trip}/comments', [QuestionsController::class, 'storeComment'])->name('comments.store');

    Route::get('/questions/{trip}/comments/{comment}/edit', [QuestionsController::class, 'showEditComment'])->name('comments.showEdit');

    Route::put('/questions/{trip}/comments/{comment}/edit', [QuestionsController::class, 'editComment'])->name('comments.update');

    Route::delete('/questions/{trip}/comments/{comment}', [QuestionsController::class, 'deleteComment'])->name('comments.destroy');

    Route::post('/questions/{trip}/bookmark', [QuestionsController::class, 'bookmarkTrip'])->name('bookmarks.store');

    Route::get('/displayBookmarks', [QuestionsController::class, 'displayBookmarks'])->name('bookmarks.display');

    Route::delete('/bookmarks/{trip}', [QuestionsController::class, 'removeBookmark'])->name('bookmarks.remove');

    #making the API routes
    Route::post('/questions/api/generateTrips', [QuestionsController::class, 'generateTrips'])->name('questions.api.generateTrips');
});

// Route::get('/questions', [QuestionsController::class, 'disaplyQuestions'])->name('questions.display');

// Route::get('/askQuestion', [QuestionsController::class, 'addTrip'])->name('questions.ask');

// Route::post('/storeQuestion', [QuestionsController::class, 'storeTrip'])->name('trip.store');

// Route::get('/questions/{trip}', [QuestionsController::class, 'showTripComments'])->name('trip.comments');

// Route::post('/questions/{trip}/comments', [QuestionsController::class, 'storeComment'])->name('comments.store');

// Route::get('/questions/{trip}/comments/{comment}/edit', [QuestionsController::class, 'showEditComment'])->name('comments.showEdit');

// Route::put('/questions/{trip}/comments/{comment}/edit', [QuestionsController::class, 'editComment'])->name('comments.update');

// Route::delete('/questions/{trip}/comments/{comment}', [QuestionsController::class, 'deleteComment'])->name('comments.destroy');

// Route::post('/questions/{trip}/bookmark', [QuestionsController::class, 'bookmarkTrip'])->name('bookmarks.store');

// Route::get('/displayBookmarks', [QuestionsController::class, 'displayBookmarks'])->name('bookmarks.display');

// Route::delete('/bookmarks/{trip}', [QuestionsController::class, 'removeBookmark'])->name('bookmarks.remove');

require __DIR__.'/auth.php';
