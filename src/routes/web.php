<?php
use ArcdevPackages\Core\Http\Controllers\AccessControlController;
use ArcdevPackages\Core\Http\Controllers\OrganizerController;
use ArcdevPackages\Core\Http\Controllers\OrganizerSettingController;
use ArcdevPackages\Core\Http\Controllers\RoleController;
use ArcdevPackages\Core\Http\Controllers\WelcomePageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use ArcdevPackages\Core\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Auth;

Route::get('getRoleList', [RoleController::class, 'getRoleList']);

Route::middleware(['web'])->group(function () {
    Route::get('/welcomeSettings', [WelcomePageController::class, 'welcomeSettings'])->name('welcomeSettings')->middleware(EnsureUserHasRole::class.':admin');
    Route::get('/getAboutUs', [WelcomePageController::class, 'getAboutUs'])->name('getAboutUs');
    Route::post('/saveAboutUs', [WelcomePageController::class, 'saveAboutUs'])->name('saveAboutUs');
    Route::get('/getMainBanner', [WelcomePageController::class, 'getMainBanner'])->name('getMainBanner');
    Route::post('/saveMainBanner', [WelcomePageController::class, 'saveMainBanner'])->name('saveMainBanner');
    Route::get('/getOverview', [WelcomePageController::class, 'getOverview'])->name('getOverview');
    Route::post('/saveOverview', [WelcomePageController::class, 'saveOverview'])->name('saveOverview');
    Route::get('/getMainCategories', [WelcomePageController::class, 'getMainCategories'])->name('getMainCategories');
    Route::post('/saveMainCategories', [WelcomePageController::class, 'saveMainCategories'])->name('saveMainCategories');
    Route::get('/getCarouselSliders', [WelcomePageController::class, 'getCarouselSliders'])->name('getCarouselSliders');
    Route::post('/saveCarouselSliders', [WelcomePageController::class, 'saveCarouselSliders'])->name('saveCarouselSliders');
    Route::get('/getGallerySwipers', [WelcomePageController::class, 'getGallerySwipers'])->name('getGallerySwipers');
    Route::post('/saveGallerySwipers', [WelcomePageController::class, 'saveGallerySwipers'])->name('saveGallerySwipers');
    Route::get('/getFeatures', [WelcomePageController::class, 'getFeatures'])->name('getFeatures');
    Route::post('/saveFeatures', [WelcomePageController::class, 'saveFeatures'])->name('saveFeatures');
    Route::get('/getBrands', [WelcomePageController::class, 'getBrands'])->name('getBrands');
    Route::post('/saveBrands', [WelcomePageController::class, 'saveBrands'])->name('saveBrands');
    Route::get('/getFooters', [WelcomePageController::class, 'getFooters'])->name('getFooters');
    Route::post('/saveFooters', [WelcomePageController::class, 'saveFooters'])->name('saveFooters');
    Route::get('/getGallery', [WelcomePageController::class, 'getGallery'])->name('getGallery');
    Route::post('/saveGallery', [WelcomePageController::class, 'saveGallery'])->name('saveGallery');

    Route::get('getOrganizerList', [OrganizerController::class, 'getOrganizerList']);

    Route::get('/getOrganizerLogo', [OrganizerController::class, 'getOrganizerLogo'])->name('getOrganizerLogo');
});

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/access_controls/getAll', [AccessControlController::class, 'getAll'])->name('getAllAccessControls');
    Route::post('/updateUserRole', [AccessControlController::class, 'updateUserRole'])->name('updateUserRole');
    Route::get('/access_controls/user_role/{user_id}', [AccessControlController::class, 'getUserRole'])->name('getUserRole');
    Route::resource('access_controls', AccessControlController::class)->middleware(EnsureUserHasRole::class.':super_admin');

    Route::get('/organizers/getAll', [OrganizerController::class, 'getAll'])->name('getAllCompanies');
    Route::resource('organizers', OrganizerController::class)->middleware(EnsureUserHasRole::class.':super_admin');

    Route::get('/organizerSettings', [OrganizerSettingController::class, 'organizerSettings'])->name('organizerSettings');
    Route::get('/getOrganizerSettings', [OrganizerSettingController::class, 'getOrganizerSettings'])->name('getOrganizerSettings');
    Route::post('/saveOrganizerSettings', [OrganizerSettingController::class, 'saveOrganizerSettings'])->name('saveOrganizerSettings');


    Route::get('/roles/getAll', [RoleController::class, 'getAll'])->name('getAllRoles');
    Route::resource('roles', RoleController::class)->names([
        'index'   => 'roles.index',
    ]);


});

require __DIR__.'/auth.php';
