<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/validate-user', 'HomeController@checkUserRole');
Route::get('/request/get-country-license-class/{id}', 'HomeController@getLicenseClassByCountry');
/*=====================================ADMIN=====================================*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/profile', 'Admin\DashboardController@myAccount');
    Route::post('/profile-edit', 'Admin\DashboardController@userProfileUpdate')->name('profile-edit');
    Route::get('/getUsesData/{startDate}/{endDate}', 'Admin\DashboardController@getUsesData');
    /*
    |-----------------------------------
    | Role Management routes here       |
    |-----------------------------------
     */
    Route::group(['prefix' => 'role-management'], function () {
        Route::get('/', 'Admin\RoleController@index');
        Route::get('role-data', 'Admin\RoleController@roleData');
        Route::post('/save-create-role', 'Admin\RoleController@RoleSave');
        Route::get('delete-role/{id}', 'Admin\RoleController@RoleDelete');
        Route::get('{id}/role-edit', 'Admin\RoleController@editRole');
        Route::post('{id}/save-edit-role', 'Admin\RoleController@saveEditRole');
    });
    /*
    |---------------------------------
    | User Management Routes Here     |
    |---------------------------------
     */
    Route::group(['prefix' => 'user-management'], function () {
        Route::get('/', 'Admin\UserManagementController@index');
        Route::get('user-data', 'Admin\UserManagementController@userData');
        Route::get('create', 'Admin\UserManagementController@create');
        Route::post('/save-user', 'Admin\UserManagementController@store');
        Route::get('{id}/edit', 'Admin\UserManagementController@edit');
        Route::post('{id}/update', 'Admin\UserManagementController@update');
        Route::get('delete/{id}', 'Admin\UserManagementController@destroy');
    });
    /*
    |------------------------------------------
    | Insurance Company Management Routes Here |
    |------------------------------------------
     */
    Route::group(['prefix' => 'insurance-company-management'], function () {
        Route::get('/', 'Admin\CompanyManagementController@index');
        Route::get('company-data', 'Admin\CompanyManagementController@masjidData');
        Route::get('create', 'Admin\CompanyManagementController@create');
        Route::post('/save-masjid', 'Admin\CompanyManagementController@store');
        Route::post('/save-compain', 'Admin\CompainController@store');
        Route::get('{id}/edit', 'Admin\CompanyManagementController@edit');
        Route::post('{id}/update', 'Admin\CompanyManagementController@update');
        Route::get('{id}/view', 'Admin\CompanyManagementController@show');
        Route::get('delete/{id}', 'Admin\CompanyManagementController@destroy');
    });
    /*
    |-----------------------------------
    | Pages Management Routes Here     |
    |-----------------------------------
     */
    Route::group(['prefix' => 'page-management'], function () {
        Route::get('/', 'Admin\CmsPageManagementController@index');
        Route::get('page-data', 'Admin\CmsPageManagementController@pageData');
        Route::get('create', 'Admin\CmsPageManagementController@create');
        Route::post('/save-page', 'Admin\CmsPageManagementController@store');
        Route::get('{id}/view', 'Admin\CmsPageManagementController@show');
        Route::get('{id}/edit', 'Admin\CmsPageManagementController@edit');
        Route::post('{id}/update', 'Admin\CmsPageManagementController@update');
        Route::get('delete/{id}', 'Admin\CmsPageManagementController@destroy');
    });
    /*
    |-----------------------------------------
    | Email Tempate Management Routes Here |
    |-----------------------------------------
     */
    Route::group(['prefix' => 'email-management'], function () {
        Route::get('/', 'Admin\EmailTemplateManagementController@index');
        Route::get('template-data', 'Admin\EmailTemplateManagementController@templateData');
        Route::get('create', 'Admin\EmailTemplateManagementController@create');
        Route::post('/save-template', 'Admin\EmailTemplateManagementController@store');
        Route::get('{id}/view', 'Admin\EmailTemplateManagementController@show');
        Route::get('{id}/edit', 'Admin\EmailTemplateManagementController@edit');
        Route::post('{id}/update', 'Admin\EmailTemplateManagementController@update');
        Route::get('delete/{id}', 'Admin\EmailTemplateManagementController@destroy');
    });

    /*
    |------------------------------
    | Management Permissions here    |
    |------------------------------
     */
    Route::group(['prefix' => 'management-permissions'], function () {
        Route::get('/', 'Admin\PermissionsManagementController@index');
        Route::post('/save-permission', 'Admin\PermissionsManagementController@store');
        Route::post('/change-permission', 'Admin\PermissionsManagementController@update');

    });
    /*
    |-------------------------------
    | license Class management Here |
    |-------------------------------
     */
    Route::group(['prefix' => 'license-class-management'], function () {
        Route::get('/', 'Admin\LicenseClassManagementController@index');
        Route::get('user-data', 'Admin\LicenseClassManagementController@userData');
        Route::get('create', 'Admin\LicenseClassManagementController@create');
        Route::post('/save-license', 'Admin\LicenseClassManagementController@store');
        Route::get('{id}/edit', 'Admin\LicenseClassManagementController@edit');
        Route::post('{id}/update', 'Admin\LicenseClassManagementController@update');
        Route::get('{id}/view', 'Admin\LicenseClassManagementController@show');
        Route::get('delete/{id}', 'Admin\LicenseClassManagementController@destroy');
    });

    /*
    |-------------------------------
    | Vehicle Type management Here |
    |-------------------------------
     */
    Route::group(['prefix' => 'vehicle-type-management'], function () {
        Route::get('/', 'Admin\VehicleTypeManagementController@index');
        Route::get('user-data', 'Admin\VehicleTypeManagementController@userData');
        Route::get('create', 'Admin\VehicleTypeManagementController@create');
        Route::post('/save-vehicle', 'Admin\VehicleTypeManagementController@store');
        Route::get('{id}/edit', 'Admin\VehicleTypeManagementController@edit');
        Route::post('{id}/update', 'Admin\VehicleTypeManagementController@update');
        Route::get('{id}/view', 'Admin\VehicleTypeManagementController@show');
        Route::get('delete/{id}', 'Admin\VehicleTypeManagementController@destroy');
    });
    /*
    |-------------------------------
    | Fuel Type Management Here     |
    |-------------------------------
     */
    Route::group(['prefix' => 'fuel-type-management'], function () {
        Route::get('/', 'Admin\FuelManagementController@index');
        Route::get('user-data', 'Admin\FuelManagementController@userData');
        Route::get('create', 'Admin\FuelManagementController@create');
        Route::post('/save-fuel', 'Admin\FuelManagementController@store');
        Route::get('{id}/edit', 'Admin\FuelManagementController@edit');
        Route::post('{id}/update', 'Admin\FuelManagementController@update');
        Route::get('{id}/view', 'Admin\FuelManagementController@show');
        Route::get('delete/{id}', 'Admin\FuelManagementController@destroy');
    });

});

/*=====================================USERS=====================================*/
Route::group(['prefix' => 'user', 'middleware' => ['users', 'auth']], function () {
    Route::get('/', 'users\DashboardController@index');
    Route::get('/profile', 'users\DashboardController@myAccount');
    Route::post('/profile-edit', 'users\DashboardController@userProfileUpdate')->name('profile-edit');
    /*
    |---------------------------------
    | User Management Routes Here    |
    |---------------------------------
     */
    Route::group(['prefix' => 'user-management'], function () {
        Route::get('/', 'users\UserManagementController@index');
        Route::get('user-data', 'users\UserManagementController@userData');
        Route::get('create', 'users\UserManagementController@create');
        Route::post('/save-user', 'users\UserManagementController@store');
        Route::get('{id}/edit', 'users\UserManagementController@edit');
        Route::post('{id}/update', 'users\UserManagementController@update');
        Route::get('delete/{id}', 'users\UserManagementController@destroy');
    });
    /*
    |-------------------------------------
    | Company Management Routes Here     |
    |-------------------------------------
     */
    Route::group(['prefix' => 'insurance-company-management'], function () {
        Route::get('/', 'users\CompanyManagementController@index');
        Route::get('company-data', 'users\CompanyManagementController@masjidData');
        Route::get('create', 'users\CompanyManagementController@create');
        Route::post('/save-masjid', 'users\CompanyManagementController@store');
        Route::post('/save-compain', 'users\CompainController@store');
        Route::get('{id}/edit', 'users\CompanyManagementController@edit');
        Route::post('{id}/update', 'users\CompanyManagementController@update');
        Route::get('{id}/view', 'users\CompanyManagementController@show');
        Route::get('delete/{id}', 'users\CompanyManagementController@destroy');
    });
    /*
    |------------------------------------------
    | Access Request Management Routes Here  |
    |------------------------------------------
     */
    Route::group(['prefix' => 'access-request-management'], function () {
        Route::get('/', 'users\AccessRequestController@index');
        Route::get('request-data', 'users\AccessRequestController@requestData');

        Route::get('{id}/grantAccess', 'users\AccessRequestController@grantAccessToCompany');

        Route::get('{id}/accept', 'users\AccessRequestController@requestAccept');
        Route::get('{id}/reject', 'users\AccessRequestController@requestReject');
        Route::get('{id}/withdraw', 'users\AccessRequestController@requestWithdraw');
        Route::get('getRequestedData/{id}', 'users\AccessRequestController@getRequestedData');
        Route::post('acceptRequest', 'users\AccessRequestController@acceptRequest');

        Route::get('create', 'users\AccessRequestController@create');
        Route::post('/save-masjid', 'users\AccessRequestController@store');
        Route::post('/save-compain', 'users\AccessRequestController@store');
        Route::post('{id}/update', 'users\AccessRequestController@update');
        Route::get('{id}/view', 'users\AccessRequestController@show');
        Route::get('delete/{id}', 'users\AccessRequestController@destroy');
    });
    /*
    |----------------------------------
    | Driver Management Routes Here  |
    |----------------------------------
     */
    Route::group(['prefix' => 'driver-management'], function () {
        Route::get('/', 'users\DriverManagementController@index');
        Route::get('driver-data', 'users\DriverManagementController@driverData');
        Route::get('{id}/accept', 'users\DriverManagementController@requestAccept');
        Route::get('{id}/reject', 'users\DriverManagementController@requestReject');
        Route::get('{id}/withdraw', 'users\DriverManagementController@requestWithdraw');
        Route::get('create', 'users\DriverManagementController@create');
        Route::post('/save-driver', 'users\DriverManagementController@store');
        Route::post('navaxyLogin', 'users\DriverManagementController@loginWithNavaxy');

        Route::get('{id}/edit', 'users\DriverManagementController@edit');
        Route::post('{id}/update', 'users\DriverManagementController@update');
        Route::get('delete/{id}', 'users\DriverManagementController@destroy');

        Route::get('/get-country-name/{id}', 'users\DriverManagementController@getCountryName');
    });
    /*
    |---------------------------------------
    | Driver Management Routes Here        |
    |---------------------------------------
     */

    Route::group(['prefix' => 'assets-management'], function () {
        Route::get('/', 'users\VehicleManagementController@index');
        Route::get('driver-data', 'users\VehicleManagementController@driverData');
        Route::get('create', 'users\VehicleManagementController@create');
        Route::post('/save-vehicle', 'users\VehicleManagementController@store');
        Route::post('navaxyLogin', 'users\VehicleManagementController@loginWithNavaxy');
        Route::get('{id}/edit', 'users\VehicleManagementController@edit');
        Route::post('{id}/update', 'users\VehicleManagementController@update');
        Route::get('delete/{id}', 'users\VehicleManagementController@destroy');

        Route::get('/get-country-name/{id}', 'users\VehicleManagementController@getCountryName');
    });

});
/*=====================================COMPANY=====================================*/
Route::group(['prefix' => 'company', 'middleware' => ['company', 'auth']], function () {
    Route::get('/', 'companies\DashboardController@index');
    Route::get('/profile', 'companies\DashboardController@myAccount');
    Route::post('/profile-edit', 'companies\DashboardController@userProfileUpdate')->name('profile-edit');
    /*
    |---------------------------------
    | User Management Routes Here     |
    |---------------------------------
     */
    Route::group(['prefix' => 'user-management'], function () {
        Route::get('/', 'companies\UserManagementController@index');
        Route::get('user-data', 'companies\UserManagementController@userData');
        Route::get('create', 'companies\UserManagementController@create');
        Route::post('/save-user', 'companies\UserManagementController@store');
        Route::get('{id}/edit', 'companies\UserManagementController@edit');
        Route::get('{id}/access', 'companies\UserManagementController@accessPermission');
        Route::get('{id}/show', 'companies\UserManagementController@testShow');
        Route::get('{id}/view', 'companies\UserManagementController@show');

        Route::post('{id}/update', 'companies\UserManagementController@update');
        Route::get('delete/{id}', 'companies\UserManagementController@destroy');

        Route::post('accessRequest', 'companies\UserManagementController@accessRequest');
        Route::get('get-trackers/{id}', 'companies\UserManagementController@getTrackers');
        Route::get('{id}/{userid}/reportShow', 'companies\UserManagementController@getTrackersReport');

        Route::get('get-tracker-data/{id}/{user_id}', 'companies\UserManagementController@getTrackerData');
        Route::get('get-tracker-report-data/{id}/{user_id}/{startDate}/{endDate}', 'companies\UserManagementController@getTrackersReportData');

    });

    Route::group(['prefix' => 'speed-management'], function () {
        Route::get('/', 'companies\SpeedingController@index');
        Route::get('speed-data', 'companies\SpeedingController@getSpeedData');
        Route::get('create', 'companies\SpeedingController@create');
        Route::post('/save-speed', 'companies\SpeedingController@store');
        Route::get('{id}/edit', 'companies\SpeedingController@edit');
        Route::get('{id}/view', 'companies\SpeedingController@show');
        Route::post('{id}/update', 'companies\SpeedingController@update');
        Route::get('delete/{id}', 'companies\SpeedingController@destroy');
    });

    /*
    |-------------------------------------
    | Company Management Routes Here |
    |-------------------------------------
     */
    Route::group(['prefix' => 'insurance-company-management'], function () {
        Route::get('/', 'companies\CompanyManagementController@index');
        Route::get('company-data', 'companies\CompanyManagementController@masjidData');
        Route::get('create', 'companies\CompanyManagementController@create');
        Route::post('/save-masjid', 'companies\CompanyManagementController@store');
        Route::post('/save-compain', 'company\CompainController@store');
        Route::get('{id}/edit', 'companies\CompanyManagementController@edit');
        Route::post('{id}/update', 'companies\CompanyManagementController@update');
        Route::get('{id}/view', 'companies\CompanyManagementController@show');
        Route::get('delete/{id}', 'companies\CompanyManagementController@destroy');
    });
});
