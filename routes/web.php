<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/', function () { //Redirect to Prefix locale Default is KA
    return redirect(route('homepagefront','ka'),301);
});  



Auth::routes();

 Route::get('argon/home', [App\Http\Controllers\HomeController::class, 'argonIndex'])->name('home');
// Auth::routes();

Route::get('argon-login', function () {return view('argon.auth.login');} )->name('argon_login');

Route::get('argon/home', 'App\Http\Controllers\HomeController@argonIndex')->name('home');

Route::group(['middleware' => 'auth','prefix'=> 'argon'], function () {
	//Route::resource('user', UserController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('about', AboutController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('news', NewsController::class);
    Route::get('homepage', [HomepageController::class,'index'])->name('homepage');
    Route::post('homepage', [HomepageController::class,'mainslider'])->name('homepage_mainslider');
    Route::post('storeslider', [HomepageController::class,'store'])->name('storeslider');
    Route::post('updatesliders', [HomepageController::class,'update_sliders'])->name('updatesliders');
    Route::delete('deleteslider/{id}',[HomepageController::class,'destroy'])->name('deleteslider');
    
    Route::delete('imgdelete/{imgid}', [Controller::class,'deleteImg'])->name('imgdelete');
    
	// Route::get('projects',[ ProjectsController::class,'admin_index'])->name('admin_projects');
    // Route::get('projects/{id}',[ ProjectsController::class,'edit'])->name('admin_projects_edit');
    // Route::post('projects/{id}',[ ProjectsController::class,'crupdate'])->name('admin_projects_crupdate');
    Route::get('user', [UserController::class,'index']);
    
    //Route::get('homepage', function () {return view('argon.pages.homepage');} )->name('argon_homepage');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('argon.pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('argon.pages.maps');})->name('map');
	 Route::get('icons', function () {return view('argon.pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('argon.pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


// Route::get('generate-link-manually-2022', function (){
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
//     echo 'ok';
// });
// Route::get('clear-cache-manually-2022', function (){
//     \Illuminate\Support\Facades\Artisan::call('config:cache');
//     \Illuminate\Support\Facades\Artisan::call('route:cache');
//     echo 'ok';
// });


Route::group(['prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localizationRedirect','localeSessionRedirect', 'localeViewPath' ]],function (){
    
     Route::get('/', [HomePageController::class,'front_index'])->name('homepagefront');    


    Route::get('/about', [AboutController::class,'front_index'])->name('about'); 

    Route::get('/about2', [AboutController::class,'front_index2'])->name('sub-about');  

    
    Route::get('/services', [ServicesController::class,'front_index'])->name('services');   

    Route::get('/services/{slug}/{id}', [ServicesController::class,'front_show'])->name('singleservice');   

    Route::get('/projects', [ProjectsController::class,'front_index'])->name('projects');   

    Route::get('/news', [NewsController::class,'front_index'])->name('news');  
    
    Route::get('/news/{id}', [NewsController::class,'front_show'])->name('singlenews');  

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');   


});
