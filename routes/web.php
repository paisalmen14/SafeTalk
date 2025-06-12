<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController; 
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController; 
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\PsychologistController as AdminPsychologistController;
use App\Http\Controllers\ChatController;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/dashboard', [StoryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('stories', StoryController::class)->except(['index', 'show', 'edit', 'update', 'destroy']);
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');
    Route::get('/story/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/story/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/story/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    
    Route::post('/stories/{story}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/stories/{story}/vote', [VoteController::class, 'vote'])->name('stories.vote');
    
    Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::resource('articles', ArticleController::class)->only(['index', 'show']);

    Route::get('/konsultasi', fn() => view('chatbot.index'))->name('chatbot.index');
    Route::post('/konsultasi/send', [App\Http\Controllers\ChatbotController::class, 'send'])->name('chatbot.send');

    // Membership & Chat Routes
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store');
    
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{psychologist}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{psychologist}', [ChatController::class, 'store'])->name('chat.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('articles', AdminArticleController::class);

    Route::get('memberships', [AdminMembershipController::class, 'index'])->name('memberships.index');
    Route::patch('memberships/{confirmation}/approve', [AdminMembershipController::class, 'approve'])->name('memberships.approve');
    Route::post('memberships/{confirmation}/reject', [AdminMembershipController::class, 'reject'])->name('memberships.reject');

    Route::get('psychologists', [AdminPsychologistController::class, 'index'])->name('psychologists.index');
    Route::patch('psychologists/{psychologist}/approve', [AdminPsychologistController::class, 'approve'])->name('psychologists.approve');
    Route::patch('psychologists/{psychologist}/reject', [AdminPsychologistController::class, 'reject'])->name('psychologists.reject');
});

require __DIR__.'/auth.php';