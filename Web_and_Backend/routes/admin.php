<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('facke_user/{count}/{user_type}', 'BulKUserController@createUser');
Route::get('add_trip_details','BulKUserController@tripDetails');
Route::get('company_details/{count}','BulKUserController@companyDetails');
Route::get('document_details/{count}/{type}','BulKUserController@documentDetails');
Route::get('help_category_pages/{count}','BulKUserController@helpCategoryPages');
Route::get('help_subcategory_pages/{count}/{category}','BulKUserController@helpSubCategoryPages');
Route::get('help_bulk/{count}/{category}/{sub_category}','BulKUserController@helpPages');
// Route::get('help/{count}/{category}/{sub_category}','BulKUserController@helpSubCategoryPages');

Route::group(['prefix' => 'admin', 'middleware' =>'admin_auth'], function () {
	Route::get('login', 'AdminController@login')->name('admin_login');
});

Route::match(['get', 'post'],'admin/authenticate', 'AdminController@authenticate');

Route::group(['prefix' => (LOGIN_USER_TYPE=='company')?'company':'admin', 'middleware' =>'admin_guest'], function () {

	Route::redirect('/',LOGIN_USER_TYPE.'/dashboard');
	Route::get('dashboard', 'AdminController@index');

	if (LOGIN_USER_TYPE == 'admin') {
		Route::get('logout', 'AdminController@logout');
	}

	// Admin Users and permission routes
	Route::group(['middleware' => 'admin_can:manage_admin'], function() {
        Route::get('admin_user', 'AdminController@view');
        Route::match(array('GET', 'POST'),'add_admin_user', 'AdminController@add');
        Route::match(array('GET', 'POST'),'edit_admin_users/{id}', 'AdminController@update');
        Route::match(array('GET', 'POST'),'delete_admin_user/{id}', 'AdminController@delete');

    });

	
	// Manage Rider
	Route::get('rider', 'RiderController@index')->middleware('admin_can:view_rider');
	Route::match(array('GET', 'POST'), 'add_rider', 'RiderController@add')->middleware('admin_can:create_rider');
	Route::match(array('GET', 'POST'), 'edit_rider/{id}', 'RiderController@update')->middleware('admin_can:update_rider');
	Route::match(array('GET', 'POST'), 'delete_rider/{id}', 'RiderController@delete')->middleware('admin_can:delete_rider');

	// Manage Driver
	Route::get('driver', 'DriverController@index')->middleware('admin_can:view_driver');
	Route::match(array('GET', 'POST'), 'add_driver', 'DriverController@add')->middleware('admin_can:create_driver');
	Route::match(array('GET', 'POST'), 'edit_driver/{id}', 'DriverController@update')->middleware('admin_can:update_driver');
	Route::match(array('GET', 'POST'), 'delete_driver/{id}', 'DriverController@delete')->middleware('admin_can:delete_driver');
	Route::post('get_documents', 'DriverController@get_documents');

	// Manage Company
	Route::get('company', 'CompanyController@index')->middleware('admin_can:view_company');
	Route::match(array('GET', 'POST'), 'add_company', 'CompanyController@add')->middleware('admin_can:create_company');
	Route::match(array('GET', 'POST'), 'edit_company/{id}', 'CompanyController@update')->middleware('admin_can:update_company');
	Route::match(array('GET', 'POST'), 'delete_company/{id}', 'CompanyController@delete')->middleware('admin_can:delete_company');


	// Manage Location
	Route::group(['middleware' => 'admin_can:manage_locations'], function() {
		Route::get('locations', 'LocationsController@index');
	    Route::match(array('GET', 'POST'),'add_location', 'LocationsController@add')->name('admin.add_location');
	    Route::match(array('GET', 'POST'),'edit_location/{id}', 'LocationsController@update')->name('admin.edit_location');
	    Route::get('delete_location/{id}', 'LocationsController@delete');
	});


    // Manage Peak Based Fare Details
	Route::group(['middleware' => 'admin_can:manage_peak_based_fare'], function() {
		Route::get('manage_fare', 'ManageFareController@index');
	    Route::match(array('GET', 'POST'),'add_manage_fare', 'ManageFareController@add')->name('admin.add_manage_fare');
	    Route::match(array('GET', 'POST'),'edit_manage_fare/{id}', 'ManageFareController@update')->name('admin.edit_manage_fare');
	    Route::get('delete_manage_fare/{id}', 'ManageFareController@delete');
	});

	// Map
	Route::group(['middleware' =>  'admin_can:manage_map'], function() {
		Route::match(array('GET', 'POST'), 'map', 'MapController@index');
		Route::match(array('GET', 'POST'), 'mapdata', 'MapController@mapdata');
	});
	Route::group(['middleware' =>  'admin_can:manage_heat_map'], function() {
		Route::match(array('GET', 'POST'), 'heat-map', 'MapController@heat_map');
		Route::match(array('GET', 'POST'), 'heat-map-data', 'MapController@heat_map_data');
	});

	// Manage Vehicle Type
	Route::group(['middleware' =>  'admin_can:manage_vehicle_type'], function() {
		Route::get('vehicle_type', 'VehicleTypeController@index');
		Route::match(array('GET', 'POST'), 'add_vehicle_type', 'VehicleTypeController@add');
		Route::match(array('GET', 'POST'), 'edit_vehicle_type/{id}', 'VehicleTypeController@update');
		Route::match(array('GET', 'POST'), 'delete_vehicle_type/{id}', 'VehicleTypeController@delete');
	});


	// Manage Vehicle
	Route::group(['middleware' =>  'admin_can:manage_vehicle'], function() {
		Route::get('vehicle', 'VehicleController@index');
		Route::match(array('GET', 'POST'), 'add_vehicle', 'VehicleController@add');
		Route::post('manage_vehicle/{company_id}/get_driver', 'VehicleController@get_driver')->name('admin.get_driver');
		Route::match(array('GET', 'POST'), 'edit_vehicle/{id}', 'VehicleController@update');
		Route::match(array('GET', 'POST'), 'delete_vehicle/{id}', 'VehicleController@delete');
		Route::match(array('GET', 'POST'), 'validate_vehicle_number','VehicleController@validate_vehicle_number');
		Route::match(array('GET', 'POST'), 'check_default','VehicleController@check_default');
	});

	// Trips
	Route::group(['middleware' =>  'admin_can:manage_trips'], function() {
		Route::match(array('GET', 'POST'), 'trips', 'TripsController@index');
		Route::get('view_trips/{id}', 'TripsController@view');
		Route::post('trips/payout/{id}', 'TripsController@payout');
		Route::get('trips/export/{from}/{to}', 'TripsController@export');
	});


	// Payments
	Route::group(['middleware' =>  'admin_can:manage_payments'], function() {
		Route::match(array('GET', 'POST'), 'payments', 'PaymentsController@index');
		Route::get('view_payments/{id}', 'PaymentsController@view');
		Route::get('payments/export/{from}/{to}', 'PaymentsController@export');
	});

	// Manage Rating
	Route::group(['middleware' =>  'admin_can:manage_rating'], function() {
		Route::get('rating', 'RatingController@index');
		Route::get('delete_rating/{id}', 'RatingController@delete');
	});

	// Manage Api credentials
	Route::match(array('GET', 'POST'), 'api_credentials', 'ApiCredentialsController@index')->middleware('admin_can:manage_api_credentials');


	// Manage Currency Routes
	Route::group(['middleware' =>  'admin_can:manage_currency'], function() {
		Route::get('currency', 'CurrencyController@index');
		Route::match(array('GET', 'POST'), 'add_currency', 'CurrencyController@add');
		Route::match(array('GET', 'POST'), 'edit_currency/{id}', 'CurrencyController@update')->where('id', '[0-9]+');
		Route::get('delete_currency/{id}', 'CurrencyController@delete')->where('id', '[0-9]+');
	});

	// Manage Document Routes
	Route::get('documents', 'DocumentsController@index')->middleware('admin_can:view_documents');
	Route::match(array('GET', 'POST'), 'add_document', 'DocumentsController@add')->middleware('admin_can:create_documents');
	Route::get('edit_document/{id}', 'DocumentsController@edit')->where('id', '[0-9]+')->middleware('admin_can:update_documents');
	Route::get('delete_document/{id}', 'DocumentsController@delete')->where('id', '[0-9]+')->middleware('admin_can:delete_documents');

	// Manage Language Routes
	Route::group(['middleware' =>  'admin_can:manage_language'], function() {
		Route::get('language', 'LanguageController@index');
		Route::match(array('GET', 'POST'), 'add_language', 'LanguageController@add');
		Route::match(array('GET', 'POST'), 'edit_language/{id}', 'LanguageController@update')->where('id', '[0-9]+');
		Route::get('delete_language/{id}', 'LanguageController@delete')->where('id', '[0-9]+');
	});

	// Manage Country
	Route::group(['middleware' => 'admin_can:manage_country'],function () {
        Route::get('country', 'CountryController@index');
        Route::match(array('GET', 'POST'), 'add_country', 'CountryController@add');
        Route::match(array('GET', 'POST'), 'edit_country/{id}', 'CountryController@update')->where('id', '[0-9]+');
        Route::get('delete_country/{id}', 'CountryController@delete')->where('id', '[0-9]+');
    });

	// Manual Booking
    Route::group(['middleware' => 'admin_can:manage_manual_booking'],function () {
        Route::get('manual_booking/{id?}', 'ManualBookingController@index');
        Route::post('manual_booking/store', 'ManualBookingController@store');
        Route::post('search_phone', 'ManualBookingController@search_phone');
        Route::post('search_cars', 'ManualBookingController@search_cars');
        Route::post('get_driver', 'ManualBookingController@get_driver');
        Route::post('driver_list', 'ManualBookingController@driver_list');
        Route::get('later_booking', 'LaterBookingController@index');
        Route::post('immediate_request', 'LaterBookingController@immediate_request');
        Route::post('manual_booking/cancel', 'LaterBookingController@cancel');
    });

    // Manage Make  Vehicle reasons
	Route::get('vehicle_make', 'MakeVehicleController@index')->middleware('admin_can:view_vehicle_make');
	Route::match(array('GET', 'POST'), 'add-vehicle-make', 'MakeVehicleController@add')->middleware('admin_can:create_vehicle_make');
	Route::match(array('GET', 'POST'), 'edit-vehicle-make/{id}', 'MakeVehicleController@update')->where('id', '[0-9]+')->middleware('admin_can:update_vehicle_make');
	Route::get('delete-vehicle_make/{id}', 'MakeVehicleController@delete')->middleware('admin_can:delete_vehicle_make');

	Route::get('vehicle_model', 'VehicleModelController@index')->middleware('admin_can:view_vehicle_model');
	Route::match(array('GET', 'POST'), 'add-vehicle_model', 'VehicleModelController@add')->middleware('admin_can:create_vehicle_model');
	Route::match(array('GET', 'POST'), 'edit-vehicle_model/{id}', 'VehicleModelController@update')->where('id', '[0-9]+')->middleware('admin_can:update_vehicle_model');
	Route::get('delete_vehicle_model/{id}', 'VehicleModelController@delete')->middleware('admin_can:delete_vehicle_make');
	Route::post('makelist','VehicleModelController@makeListValue');

});

