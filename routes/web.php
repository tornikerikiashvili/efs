<?php

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\News;
use App\Models\Projects;
use App\Models\Services;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PartnerLogoController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SiteSeoController;
use App\Http\Controllers\SitemapController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('sitemap.xml', SitemapController::class)->name('sitemap');

Route::redirect('ka', '/', 301);
Route::get('ka/{path}', function (string $path) {
    return redirect('/'.ltrim($path, '/'), 301);
})->where('path', '.*');

Route::get('/', function () {
    return redirect()->route('homepagefront', [], 301);
});

Auth::routes();

Route::get('argon-login', function () {
    return view('argon.auth.login');
})->name('argon_login');

Route::group(['middleware' => 'auth', 'prefix' => 'argon'], function () {
    Route::get('home', [HomeController::class, 'argonIndex'])->name('home');
    Route::resource('projects', ProjectsController::class);
    Route::resource('about', AboutController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('news', NewsController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('team-members', TeamMemberController::class);
    Route::resource('partner-logos', PartnerLogoController::class);
    Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::get('translations/{group}/edit', [TranslationController::class, 'edit'])->name('translations.edit');
    Route::put('translations/{group}', [TranslationController::class, 'update'])->name('translations.update');
    Route::get('site-seo', [SiteSeoController::class, 'edit'])->name('site-seo.edit');
    Route::put('site-seo', [SiteSeoController::class, 'update'])->name('site-seo.update');
    Route::get('homepage', [HomePageController::class, 'index'])->name('homepage');
    Route::post('homepage', [HomePageController::class, 'mainslider'])->name('homepage_mainslider');
    Route::post('storeslider', [HomePageController::class, 'store'])->name('storeslider');
    Route::post('updatesliders', [HomePageController::class, 'update_sliders'])->name('updatesliders');
    Route::delete('deleteslider/{id}', [HomePageController::class, 'destroy'])->name('deleteslider');
    Route::delete('imgdelete/{imgid}', [Controller::class, 'deleteImg'])->name('imgdelete');
    Route::get('user', [UserController::class, 'index']);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('upgrade', function () {
        return view('argon.pages.upgrade');
    })->name('upgrade');
    Route::get('map', function () {
        return view('argon.pages.maps');
    })->name('map');
    Route::get('icons', function () {
        return view('argon.pages.icons');
    })->name('icons');
    Route::get('table-list', function () {
        return view('argon.pages.tables');
    })->name('table');
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect', 'localeViewPath', 'syncLocaleSession'],
], function () {
    Route::get('/', [HomePageController::class, 'front_index'])->name('homepagefront');
    Route::get('/about', [AboutController::class, 'front_index'])->name('about');

    Route::get('/about2', function () {
        return redirect()->route('about', [], 301);
    })->name('sub-about');
    Route::get('/services', [ServicesController::class, 'front_index'])->name('services');

    Route::get('/services/{slug}/{id}', function ($slug, $id) {
        $service = Services::where('status', 1)->find($id);
        abort_unless($service, 404);

        return redirect()->route('singleservice', ['slug' => $service->slugForLocale()], 301);
    })->where('id', '[0-9]+');

    Route::get('/services/{slug}', [ServicesController::class, 'front_show'])->name('singleservice');

    Route::get('/projects', [ProjectsController::class, 'front_index'])->name('projects');

    Route::get('/projects/{slug}/{id}', function ($slug, $id) {
        $project = Projects::where('status', 1)->find($id);
        abort_unless($project, 404);

        return redirect()->route('singleproject', ['slug' => $project->slugForLocale()], 301);
    })->where('id', '[0-9]+');

    Route::get('/projects/{slug}', [ProjectsController::class, 'front_show'])->name('singleproject');

    Route::get('/news', [NewsController::class, 'front_index'])->name('news');
    Route::get('/news/{slug}', [NewsController::class, 'front_show'])->name('singlenews');

    Route::get('/blog', [BlogController::class, 'front_index'])->name('blog');
    Route::get('/blog/{slug}', [BlogController::class, 'front_show'])->name('singleblog');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
});
