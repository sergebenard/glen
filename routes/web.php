<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/tools', 'PageController@tools')->name('tools');

Route::resource(	'jobs/{job}/materials',
					'JobMaterialsController',
					['names' => [
    						'index' => 'jobs.materials.index',
    						'create' => 'jobs.materials.create',
    						'store' => 'jobs.materials.store',
    						'show' => 'jobs.materials.show',
    						'edit' => 'jobs.materials.edit',
    						'update' => 'jobs.materials.update',
    						'destroy' => 'jobs.materials.destroy',
						]
					]);

Route::resource('/jobs', 'JobController');

Route::get('/home', 'HomeController@index')->name('home');

/*
ACTIONS HANDLED BY RESOURCE CONTROLLER
VERB		URI						ACTION		ROUTE NAME
GET			/photos					index		photos.index
GET			/photos/create			create		photos.create
POST		/photos					store		photos.store
GET			/photos/{photo}			show		photos.show
GET			/photos/{photo}/edit	edit		photos.edit
PUT/PATCH	/photos/{photo}			update		photos.update
DELETE		/photos/{photo}			destroy		photos.destroy
*/