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
use App\Http\Controllers\Auth\PsychologistRegisterController;

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

// Rute ini diubah untuk menampilkan welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [StoryController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('register/psychologist', [PsychologistRegisterController::class, 'create'])->middleware('guest')->name('psychologist.register');
Route::post('register/psychologist', [PsychologistRegisterController::class, 'store'])->middleware('guest');

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
    // Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    // Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store');
    
 Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/consultation/{consultation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/consultation/{consultation}', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');

    
      // --- Rute untuk Psikolog ---
    Route::middleware(['role:psikolog'])->prefix('psychologist')->name('psychologist.')->group(function () {
        // Mengelola harga dan profil lainnya
        // Rute untuk pengaturan harga
    Route::get('/price-settings', [App\Http\Controllers\Psychologist\PriceController::class, 'edit'])->name('price.edit');
    Route::put('/price-settings', [App\Http\Controllers\Psychologist\PriceController::class, 'update'])->name('price.update');

    // Rute BARU untuk foto profil
    Route::get('/profile-picture', [App\Http\Controllers\Psychologist\ProfilePictureController::class, 'edit'])->name('profile_picture.edit');
    Route::post('/profile-picture', [App\Http\Controllers\Psychologist\ProfilePictureController::class, 'update'])->name('profile_picture.update');

        // Mengelola jadwal ketersediaan
        Route::get('/availability', [App\Http\Controllers\Psychologist\AvailabilityController::class, 'index'])->name('availability.index');
        Route::post('/availability', [App\Http\Controllers\Psychologist\AvailabilityController::class, 'store'])->name('availability.store');
        Route::delete('/availability/{availability}', [App\Http\Controllers\Psychologist\AvailabilityController::class, 'destroy'])->name('availability.destroy');
    });

    // --- Rute untuk Pasien/User ---
    Route::middleware(['role:pengguna'])->prefix('consultations')->name('consultations.')->group(function () {
        // Melihat daftar psikolog dan membuat reservasi
        Route::get('/', [App\Http\Controllers\ConsultationController::class, 'index'])->name('index');
        Route::get('/psychologist/{psychologist}', [App\Http\Controllers\ConsultationController::class, 'show'])->name('psychologist.show');
        Route::post('/reserve', [App\Http\Controllers\ConsultationController::class, 'store'])->name('reserve');

        // Halaman pembayaran dan proses upload bukti
        Route::get('/{consultation}/payment', [App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
        Route::post('/{consultation}/payment', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');
    });

    // --- Rute Bersama untuk Melihat Riwayat Konsultasi ---
    Route::get('/my-consultations', [App\Http\Controllers\ConsultationController::class, 'history'])->name('consultations.history');


});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('articles', AdminArticleController::class);

    // Route::get('memberships', [AdminMembershipController::class, 'index'])->name('memberships.index');
    // Route::patch('memberships/{confirmation}/approve', [AdminMembershipController::class, 'approve'])->name('memberships.approve');
    // Route::post('memberships/{confirmation}/reject', [AdminMembershipController::class, 'reject'])->name('memberships.reject');

    Route::get('psychologists', [AdminPsychologistController::class, 'index'])->name('psychologists.index');
    Route::patch('psychologists/{psychologist}/approve', [AdminPsychologistController::class, 'approve'])->name('psychologists.approve');
    Route::patch('psychologists/{psychologist}/reject', [AdminPsychologistController::class, 'reject'])->name('psychologists.reject');

    Route::get('/consultation-verifications', [App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('consultation.verifications.index');
    Route::post('/consultation-verifications/{consultation}/approve', [App\Http\Controllers\Admin\VerificationController::class, 'approve'])->name('consultation.verifications.approve');
    Route::post('/consultation-verifications/{consultation}/reject', [App\Http\Controllers\Admin\VerificationController::class, 'reject'])->name('consultation.verifications.reject');

      Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    
});

require __DIR__.'/auth.php';