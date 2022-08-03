<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{ HomeController,
    AdminController,
    RoleController,
    UserController,
    EmailController,
    GlobalSettingController,
    LoginSliderController,
    SocialMediaController,
    MetaController,
    StaticPageController,
    TeamController,
    MatchController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('login', [HomeController::class,'index'])->name('login');
    Route::post('authenticate', [HomeController::class,'authenticate'])->name('authenticate');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('logout', [HomeController::class,'logout'])->name('logout');
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });

    Route::match(['GET','POST'],'dashboard', [HomeController::class,'dashboard'])->name('dashboard');

    // Manage Admin Users Routes
    Route::group(['prefix' => 'admin-users'], function () {
        Route::get('/', [AdminController::class,'index'])->name('admin_users')->middleware('permission:view-admin_users');
        Route::get('create', [AdminController::class,'create'])->name('admin_users.create')->middleware('permission:create-admin_users');
        Route::post('/', [AdminController::class,'store'])->name('admin_users.store')->middleware('permission:create-admin_users');
        Route::get('{id}/edit', [AdminController::class,'edit'])->name('admin_users.edit')->middleware('permission:update-admin_users');
        Route::match(['PUT','PATCH'],'{id}', [AdminController::class,'update'])->name('admin_users.update')->middleware('permission:update-admin_users');
        Route::delete('{id}', [AdminController::class,'destroy'])->name('admin_users.delete')->middleware('permission:delete-admin_users');
    });

    // Manage Roles and Permission Routes
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class,'index'])->name('roles')->middleware('permission:view-roles');
        Route::get('create', [RoleController::class,'create'])->name('roles.create')->middleware('permission:create-roles');
        Route::post('/', [RoleController::class,'store'])->name('roles.store')->middleware('permission:create-roles');
        Route::get('{id}/edit', [RoleController::class,'edit'])->name('roles.edit')->middleware('permission:update-roles');
        Route::match(['PUT','PATCH'],'{id}', [RoleController::class,'update'])->name('roles.update')->middleware('permission:update-roles');
        Route::delete('{id}', [RoleController::class,'destroy'])->name('roles.delete')->middleware('permission:delete-roles');
    });

    // Manage Users Routes
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class,'index'])->name('users')->middleware('permission:view-users');
        Route::get('create', [UserController::class,'create'])->name('users.create')->middleware('permission:create-users');
        Route::post('/', [UserController::class,'store'])->name('users.store')->middleware('permission:create-users');
        Route::get('{id}/edit', [UserController::class,'edit'])->name('users.edit')->middleware('permission:update-users');
        Route::match(['PUT','PATCH'],'{id}', [UserController::class,'update'])->name('users.update')->middleware('permission:update-users');
        Route::delete('{id}', [UserController::class,'destroy'])->name('users.delete')->middleware('permission:delete-users');
    });

    // Manage Global Settings Routes
    Route::group(['prefix' => 'global-settings'], function () {
        Route::get('/', [GlobalSettingController::class,'index'])->name('global_settings')->middleware('permission:view-global_settings');
        Route::match(['PUT','PATCH'],'/', [GlobalSettingController::class,'update'])->name('global_settings.update')->middleware('permission:update-global_settings');
    });

    // Manage Login Sliders Routes
    Route::group(['prefix' => 'login-sliders'], function () {
        Route::get('/', [LoginSliderController::class,'index'])->name('login_sliders')->middleware('permission:view-login_sliders');
        Route::get('create', [LoginSliderController::class,'create'])->name('login_sliders.create')->middleware('permission:create-login_sliders');
        Route::post('/', [LoginSliderController::class,'store'])->name('login_sliders.store')->middleware('permission:create-login_sliders');
        Route::get('{id}/edit', [LoginSliderController::class,'edit'])->name('login_sliders.edit')->middleware('permission:update-login_sliders');
        Route::match(['PUT','PATCH'],'{id}', [LoginSliderController::class,'update'])->name('login_sliders.update')->middleware('permission:update-login_sliders');
        Route::delete('{id}', [LoginSliderController::class,'destroy'])->name('login_sliders.delete')->middleware('permission:delete-login_sliders');
    });

    // Manage Social Media Links Routes
    Route::group(['prefix' => 'social-media-links'], function () {
        Route::get('/', [SocialMediaController::class,'index'])->name('social_media_links')->middleware('permission:view-social_media_links');
        Route::match(['PUT','PATCH'],'/', [SocialMediaController::class,'update'])->name('social_media_links.update')->middleware('permission:update-social_media_links');
    });

    // Manage Meta Routes
    Route::group(['prefix' => 'meta'], function () {
        Route::get('/', [MetaController::class,'index'])->name('metas')->middleware('permission:view-metas');
        Route::get('{id}/edit', [MetaController::class,'edit'])->name('metas.edit')->middleware('permission:update-metas');
        Route::match(['PUT','PATCH'],'{id}', [MetaController::class,'update'])->name('metas.update')->middleware('permission:update-metas');
    });

    // Manage Teams Routes
    Route::group(['prefix' => 'teams'], function () {
        Route::get('/', [TeamController::class,'index'])->name('teams')->middleware('permission:view-teams');
        Route::get('create', [TeamController::class,'create'])->name('teams.create')->middleware('permission:create-teams');
        Route::post('/', [TeamController::class,'store'])->name('teams.store')->middleware('permission:create-teams');
        Route::get('{id}/edit', [TeamController::class,'edit'])->name('teams.edit')->middleware('permission:update-teams');
        Route::match(['PUT','PATCH'],'{id}', [TeamController::class,'update'])->name('teams.update')->middleware('permission:update-teams');
        Route::delete('{id}', [TeamController::class,'destroy'])->name('teams.delete')->middleware('permission:delete-teams');
    });

    // Manage Matches Routes
    Route::group(['prefix' => 'matches'], function () {
        Route::get('/', [MatchController::class,'index'])->name('matches')->middleware('permission:view-matches');
        Route::get('create', [MatchController::class,'create'])->name('matches.create')->middleware('permission:create-matches');
        Route::post('/', [MatchController::class,'store'])->name('matches.store')->middleware('permission:create-matches');
        Route::get('{id}/edit', [MatchController::class,'edit'])->name('matches.edit')->middleware('permission:update-matches');
        Route::match(['PUT','PATCH'],'{id}', [MatchController::class,'update'])->name('matches.update')->middleware('permission:update-matches');
        Route::delete('{id}', [MatchController::class,'destroy'])->name('matches.delete')->middleware('permission:delete-matches');
    });
});