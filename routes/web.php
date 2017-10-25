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

Route::resource(	'jobs/{job}/labour',
					'JobLabourController',
					['names' => [
    						'index' => 'jobs.labour.index',
    						'create' => 'jobs.labour.create',
    						'store' => 'jobs.labour.store',
    						'show' => 'jobs.labour.show',
    						'edit' => 'jobs.labour.edit',
    						'update' => 'jobs.labour.update',
    						'destroy' => 'jobs.labour.destroy',
						]
					]);

Route::post('jobs/{job}/invoices/{invoice}/toggle-send', 'JobInvoicesController@toggleSend')->name('jobs.invoices.toggleSend');
Route::post('jobs/{job}/invoices/{invoice}/send', 'JobInvoicesController@send')->name('jobs.invoices.send');

Route::post('jobs/{job}/invoices/{invoice}/toggle-pay', 'JobInvoicesController@togglePay')->name('jobs.invoices.togglePay');

Route::get('jobs/{job}/invoices/{invoice}/print', 'JobInvoicesController@print')->name('jobs.invoices.print');

Route::resource(	'jobs/{job}/invoices',
					'JobInvoicesController',
					['names' => [
    						'index' => 'jobs.invoices.index',
    						'create' => 'jobs.invoices.create',
    						'store' => 'jobs.invoices.store',
    						'show' => 'jobs.invoices.show',
    						'edit' => 'jobs.invoices.edit',
    						'update' => 'jobs.invoices.update',
    						'destroy' => 'jobs.invoices.destroy',
						]
					]);

Route::resource(	'jobs/{job}/invoices/{invoice}/materials',
					'JobInvoicesMaterialsController',
					['names' => [
    						'index' => 'jobs.invoices.materials.index',
    						'create' => 'jobs.invoices.materials.create',
    						'store' => 'jobs.invoices.materials.store',
    						'show' => 'jobs.invoices.materials.show',
    						'edit' => 'jobs.invoices.materials.edit',
    						'update' => 'jobs.invoices.materials.update',
    						'destroy' => 'jobs.invoices.materials.destroy',
						]
					]);

Route::resource(	'jobs/{job}/invoices/{invoice}/labour',
					'JobInvoicesLabourController',
					['names' => [
    						'index' => 'jobs.invoices.labour.index',
    						'create' => 'jobs.invoices.labour.create',
    						'store' => 'jobs.invoices.labour.store',
    						'show' => 'jobs.invoices.labour.show',
    						'edit' => 'jobs.invoices.labour.edit',
    						'update' => 'jobs.invoices.labour.update',
    						'destroy' => 'jobs.invoices.labour.destroy',
						]
					]);

Route::post('jobs/{job}/proposals/{proposal}/toggle-send', 'JobProposalsController@toggleSend')->name('jobs.proposals.toggleSend');
Route::post('jobs/{job}/proposals/{proposal}/send', 'JobProposalsController@send')->name('jobs.proposals.send');
Route::get('jobs/{job}/proposals/{proposal}/change-status/{status}', 'JobProposalsController@changeStatus')->name('jobs.proposals.changeStatus');

Route::get('jobs/{job}/proposals/{proposal}/print', 'JobProposalsController@print')->name('jobs.proposals.print');

Route::resource(	'jobs/{job}/proposals',
					'JobProposalsController',
					['names' => [
    						'index' => 'jobs.proposals.index',
    						'create' => 'jobs.proposals.create',
    						'store' => 'jobs.proposals.store',
    						'show' => 'jobs.proposals.show',
    						'edit' => 'jobs.proposals.edit',
    						'update' => 'jobs.proposals.update',
    						'destroy' => 'jobs.proposals.destroy',
						]
					]);

Route::resource(	'jobs/{job}/proposals/{proposal}/materials',
					'JobProposalsMaterialsController',
					['names' => [
    						'index' => 'jobs.proposals.materials.index',
    						'create' => 'jobs.proposals.materials.create',
    						'store' => 'jobs.proposals.materials.store',
    						'show' => 'jobs.proposals.materials.show',
    						'edit' => 'jobs.proposals.materials.edit',
    						'update' => 'jobs.proposals.materials.update',
    						'destroy' => 'jobs.proposals.materials.destroy',
						]
					]);

Route::resource(	'jobs/{job}/proposals/{proposal}/labour',
					'JobProposalsLabourController',
					['names' => [
    						'index' => 'jobs.proposals.labour.index',
    						'create' => 'jobs.proposals.labour.create',
    						'store' => 'jobs.proposals.labour.store',
    						'show' => 'jobs.proposals.labour.show',
    						'edit' => 'jobs.proposals.labour.edit',
    						'update' => 'jobs.proposals.labour.update',
    						'destroy' => 'jobs.proposals.labour.destroy',
						]
					]);

Route::resource('/jobs', 'JobController');

Route::view('/calculator', 'calculator')->name('calculator');

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