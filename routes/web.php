<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/kontakt', [\App\Http\Controllers\HomeController::class, 'store'])->name('home.contact');
Route::post('posalji-kod', [\App\Http\Controllers\PhoneAuthController::class, 'code'])->name('phone.code');
Route::post('phone/verify', [\App\Http\Controllers\PhoneAuthController::class, 'login'])->name('phone.login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('user/phone/add', [\App\Http\Controllers\PhoneAuthController::class, 'verify'])->name('phone.verify');

    Route::get('/korisnik/podesavanja', [\App\Http\Controllers\UserSettingsController::class, 'edit'])->name('setting.edit');
    Route::patch('/korisnik/podesavanja', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('setting.update');

    Route::get('/poruka', [\App\Http\Controllers\MessagesController::class, 'index'])->name('message.index');
    Route::get('/message/unread', [\App\Http\Controllers\MessagesController::class, 'unread'])->name('message.unread');
    Route::get('/poruka/{thread}', [\App\Http\Controllers\MessagesController::class, 'show'])->name('message.show');
    Route::post('/poruka/{listing?}', [\App\Http\Controllers\MessagesController::class, 'store'])->name('message.store');
    Route::patch('/poruka/{thread}', [\App\Http\Controllers\MessagesController::class, 'update'])->name('message.update');
    Route::delete('/messages', [\App\Http\Controllers\MessagesController::class, 'destroy'])->name('message.delete');

    Route::get('/korisnik/oglasi', [\App\Http\Controllers\UserListingsController::class, 'index'])->name('user-listing.index');

    Route::get('/pratim', [\App\Http\Controllers\BookmarksController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmark/{listing}', [\App\Http\Controllers\BookmarksController::class, 'store'])->name('bookmark.store');

    Route::get('/nekretnina/kreiraj', [\App\Http\Controllers\ListingsController::class, 'create'])->name('listing.create');
    Route::post('/nekretnina', [\App\Http\Controllers\ListingsController::class, 'store'])->name('listing.store');
    Route::get('/nekretnina/{listing}/edit/{step?}', [\App\Http\Controllers\ListingsController::class, 'edit'])->name('listing.edit');
    Route::patch('/nekretnina/{listing}/rent', [\App\Http\Controllers\ListingsController::class, 'rent'])->name('listing.rent');
    Route::patch('/nekretnina/{listing}/draft', [\App\Http\Controllers\ListingsController::class, 'draft'])->name('listing.draft');
    Route::patch('/nekretnina/{listing}/publish', [\App\Http\Controllers\ListingsController::class, 'publish'])->name('listing.publish');
    Route::patch('/nekretnina/{listing}/{step}', [\App\Http\Controllers\ListingsController::class, 'update'])->name('listing.update');
    Route::delete('/listing/{listing}', [\App\Http\Controllers\ListingsController::class, 'destroy'])->name('listing.delete');

    Route::post('/upload/{listing}', [\App\Http\Controllers\ImagesController::class, 'store'])->name('image.store');
    Route::delete('/upload/{listing}',   [\App\Http\Controllers\ImagesController::class,       'destroy'   ])->name('image.delete');
});

Route::get('/nekretnina/{listing}', [\App\Http\Controllers\ListingsController::class, 'show'])->name('listing.show');
Route::get('/nekretnine', [\App\Http\Controllers\ListingsController::class, 'index'])->name('listing.index');

Route::get('/social/{provider}', [\App\Http\Controllers\SocialLoginController::class, 'redirect']);
Route::get('{provider}/callback', [\App\Http\Controllers\SocialLoginController::class, 'callback']);

Route::get('/stranica/{page}', [\App\Http\Controllers\PagesController::class, 'show'])->name('page.show');

Route::get('/oglasi-nekretninu-za-izdavanje', function (){
    return Inertia::render('Advertise/Show', [
        'qa' => trans('qa'),
        'meta' => ['description' => config('app_settings.values.create_meta_description')],
    ]);
})->name('advertise');

Route::get('/kontaktiraj-nas', function (){
    return Inertia::render('ContactUs/Show');
})->name('contact-us.show');

Route::get('/vlasnik/{user}', [\App\Http\Controllers\LandlordsController::class, 'show'])->name('landlord.show');

Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/', [\App\Http\Controllers\AdminsController::class, 'index'])->name('admin.home');

    Route::get('/maintenance', [\App\Http\Controllers\AdminsController::class, 'maintenance'])->name('admin.maintenance');
    Route::post('shut/down', [\App\Http\Controllers\AdminsController::class, 'down'])->name('admin.maintenance.down');
    Route::get('bring/up', [\App\Http\Controllers\AdminsController::class, 'up'])->name('admin.maintenance.up');

    Route::get('sitemap', [\App\Http\Controllers\AdminsController::class, 'sitemap'])->name('admin.sitemap.show');
    Route::get('sitemap/update', [\App\Http\Controllers\AdminsController::class, 'sitemapUpdate'])->name('admin.sitemap.update');

    Route::get('/backup', [\App\Http\Controllers\BackupController::class, 'index'])->name('admin.backup.index');
    Route::get('/backup/{disk}/{file_name}/download', [\App\Http\Controllers\BackupController::class, 'download'])->name('admin.backup.download');
    Route::delete('/backup/{disk}/{file_name}', [\App\Http\Controllers\BackupController::class, 'delete'])->name('admin.backup.delete');
    Route::get('/backup/check', [\App\Http\Controllers\BackupController::class, 'check'])->name('admin.backup.check');
    Route::get('/backup/{type}', [\App\Http\Controllers\BackupController::class, 'store'])->name('admin.backup.create');

    Route::get('/logovi/{date}/{level}/pretraga', [\App\Http\Controllers\LogsController::class, 'search'])->name('admin.log.search');
    Route::get('/logovi/{date}/{level}/filter', [\App\Http\Controllers\LogsController::class, 'filter'])->name('admin.log.filter');
    Route::get('/logovi/{date}/download', [\App\Http\Controllers\LogsController::class, 'download'])->name('admin.log.download');
    Route::get('/logovi/{date}', [\App\Http\Controllers\LogsController::class, 'show'])->name('admin.log.show');
    Route::delete('/logovi/{date}', [\App\Http\Controllers\LogsController::class, 'delete'])->name('admin.log.delete');
    Route::get('/logovi', [\App\Http\Controllers\LogsController::class, 'index'])->name('admin.log.index');

    Route::get('/health/panel', [\App\Http\Controllers\AdminsController::class, 'health'])->name('admin.health');

    Route::get('/stranica', [\App\Http\Controllers\PagesController::class, 'index'])->name('admin.page.index');
    Route::get('/stranica/{page}/edit', [\App\Http\Controllers\PagesController::class, 'edit'])->name('admin.page.edit');
    Route::get('/stranica/kreiraj', [\App\Http\Controllers\PagesController::class, 'create'])->name('admin.page.create');
    Route::post('/stranica', [\App\Http\Controllers\PagesController::class, 'store'])->name('admin.page.store');
    Route::delete('/stranica/{page}', [\App\Http\Controllers\PagesController::class, 'destroy'])->name('admin.page.delete');
    Route::patch('/stranica/{page}', [\App\Http\Controllers\PagesController::class, 'update'])->name('admin.page.update');

    Route::delete('/poruka/{thread}/undelete', [\App\Http\Controllers\AdminThreadsController::class, 'undelete'])->withTrashed()->name('admin.thread.undelete');
    Route::delete('/poruka/{thread}', [\App\Http\Controllers\AdminThreadsController::class, 'destroy'])->name('admin.thread.delete');
    Route::get('/poruka', [\App\Http\Controllers\AdminThreadsController::class, 'index'])->name('admin.thread.index');
    Route::get('/poruka/{thread}', [\App\Http\Controllers\AdminThreadsController::class, 'show'])->withTrashed()->name('admin.thread.show');

    Route::patch('/korisnik/{user}/podesavanja', [\App\Http\Controllers\AdminUsersController::class, 'settings'])->name('admin.setting.update');
    Route::get('/korisnik/{user}/izmeni', [\App\Http\Controllers\AdminUsersController::class, 'edit'])->name('admin.user.edit');
    Route::put('/korisnik/{user}', [\App\Http\Controllers\AdminUsersController::class, 'update'])->name('admin.user.update');
    Route::delete('/korisnik/{user}/slika', [\App\Http\Controllers\AdminUsersController::class, 'destroyImage'])->name('admin.user.image.delete');
    Route::get('/korisnik/{user}', [\App\Http\Controllers\AdminUsersController::class, 'show'])->name('admin.user.show');
    Route::delete('/korisnik/{user}', [\App\Http\Controllers\AdminUsersController::class, 'destroy'])->name('admin.user.delete');
    Route::get('/korisnik', [\App\Http\Controllers\AdminUsersController::class, 'index'])->name('admin.user.index');

    Route::get('/nekretnina', [\App\Http\Controllers\AdminListingsController::class, 'index'])->name('admin.listing.index');
    Route::get('/nekretnina/kreiraj', [\App\Http\Controllers\AdminListingsController::class, 'create'])->name('admin.listing.create');
    Route::post('/nekretnina', [\App\Http\Controllers\AdminListingsController::class, 'store'])->name('admin.listing.store');
    Route::delete('/nekretnina/{listing}/undelete', [\App\Http\Controllers\AdminListingsController::class, 'undelete'])->withTrashed()->name('admin.listing.undelete');
    Route::get('/mail', [\App\Http\Controllers\AdminsController::class, 'mail'])->name('admin.mail.create');
    Route::post('/mail', [\App\Http\Controllers\AdminsController::class, 'send'])->name('admin.mail.send');

});
