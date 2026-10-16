
<?php
use App\Http\Controllers\Auth\AcceptInvitationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Admin\RoadmapController;
use App\Http\Controllers\Learner\RoadmapController as LearnerRoadmapController;
use App\Http\Controllers\Admin\RoadmapSectionController;
use App\Http\Controllers\Admin\TopicResourceController;
use App\Http\Controllers\Learner\TopicCompletionController;
use App\Http\Controllers\Learner\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LearnerController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])
    ->get('/admin-check', function () {
        return 'NeuralPath Admin Access Granted';
    });

Route::middleware(['auth', 'admin'])
    ->get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )
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
    ->get('/dashboard', [
        DashboardController::class,
        'index',
    ])
    ->name('learner.dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/roadmap', [RoadmapController::class, 'index'])
            ->name('roadmap.index');

        Route::patch(
            '/roadmap/{branch}/publication',
            [RoadmapController::class, 'togglePublication']
        )->name('roadmap.publication');
    });    

Route::middleware(['auth', 'learner'])
    ->prefix('roadmap')
    ->name('learner.roadmap.')
    ->group(function () {
        Route::get('/', [
            LearnerRoadmapController::class,
            'index',
        ])->name('index');

        Route::get('/{branch}', [
            LearnerRoadmapController::class,
            'show',
        ])->name('show');
    });    

Route::middleware(['auth', 'admin'])
    ->prefix('admin/roadmap/{branch}')
    ->name('admin.roadmap.')
    ->group(function () {

        Route::get(
            '/sections',
            [RoadmapSectionController::class, 'index']
        )->name('sections');

        Route::get(
            '/sections/create',
            [RoadmapSectionController::class, 'createSection']
        )->name('sections.create');

        Route::post(
            '/sections',
            [RoadmapSectionController::class, 'storeSection']
        )->name('sections.store');

        Route::get(
            '/sections/{section}/edit',
            [RoadmapSectionController::class, 'editSection']
        )->name('sections.edit');

        Route::put(
            '/sections/{section}',
            [RoadmapSectionController::class, 'updateSection']
        )->name('sections.update');

        Route::patch(
            '/sections/{section}/publication',
            [RoadmapSectionController::class, 'toggleSection']
        )->name('sections.publication');

        Route::get(
            '/sections/{section}/topics/create',
            [RoadmapSectionController::class, 'createTopic']
        )->name('topics.create');

        Route::post(
            '/sections/{section}/topics',
            [RoadmapSectionController::class, 'storeTopic']
        )->name('topics.store');

        Route::get(
            '/sections/{section}/topics/{topic}/edit',
            [RoadmapSectionController::class, 'editTopic']
        )->name('topics.edit');

        Route::put(
            '/sections/{section}/topics/{topic}',
            [RoadmapSectionController::class, 'updateTopic']
        )->name('topics.update');

        Route::patch(
            '/sections/{section}/topics/{topic}/publication',
            [RoadmapSectionController::class, 'toggleTopic']
        )->name('topics.publication');
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin/roadmap/{branch}/sections/{section}/topics/{topic}/resources')
    ->name('admin.roadmap.resources.')
    ->group(function () {
        Route::get('/', [
            TopicResourceController::class,
            'index',
        ])->name('index');

        Route::post('/', [
            TopicResourceController::class,
            'store',
        ])->name('store');

        Route::put('/{resource}', [
            TopicResourceController::class,
            'update',
        ])->name('update');

        Route::patch('/{resource}/publication', [
            TopicResourceController::class,
            'togglePublication',
        ])->name('publication');
    });
Route::middleware(['auth', 'learner'])
    ->prefix('roadmap/topics')
    ->name('learner.topics.')
    ->group(function () {
        Route::put(
            '/{topic}/completion',
            [TopicCompletionController::class, 'complete']
        )->name('complete');

        Route::delete(
            '/{topic}/completion',
            [TopicCompletionController::class, 'incomplete']
        )->name('incomplete');
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin/learners')
    ->name('admin.learners.')
    ->group(function () {

        Route::get('/', [
            LearnerController::class,
            'index',
        ])->name('index');

        Route::get('/{learner}', [
            LearnerController::class,
            'show',
        ])
        ->whereNumber('learner')
        ->name('show');

        Route::patch('/{learner}/status', [
            LearnerController::class,
            'updateStatus',
        ])
        ->whereNumber('learner')
        ->middleware('throttle:20,1')
        ->name('status');
    });
