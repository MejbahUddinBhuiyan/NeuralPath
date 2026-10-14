
<?php
use App\Http\Controllers\Auth\AcceptInvitationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InvitationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])
    ->get('/admin-check', function () {
        return 'NeuralPath Admin Access Granted';
    });

Route::middleware(['auth', 'admin'])
    ->get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })
    ->name('admin.dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/invitations', [
            InvitationController::class,
            'index',
        ])->name('invitations.index');

        Route::post('/invitations', [
            InvitationController::class,
            'store',
        ])->middleware('throttle:5,1')
          ->name('invitations.store');
    });

Route::middleware('guest')
    ->group(function () {
        Route::get(
            '/invitations/accept/{token}',
            [AcceptInvitationController::class, 'show']
        )->name('invitations.accept');

        Route::post(
            '/invitations/accept/{token}',
            [AcceptInvitationController::class, 'store']
        )
        ->middleware('throttle:5,1')
        ->name('invitations.complete');
    });
Route::middleware(['auth', 'learner'])
    ->get('/dashboard', function () {
        return view('learner.dashboard');
    })
    ->name('learner.dashboard');