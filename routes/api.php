<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');
Route::group(['namespace' => 'API', 'prefix' => 'password'], function () {
	Route::post('forget', 'PasswordResetController@create');
	Route::get('validate/{token}', 'PasswordResetController@find');
	Route::post('reset', 'PasswordResetController@reset');
});
/* Route for Public URL API */
Route::group(['prefix' => 'public'], function () {
	/* Route for Masjid API */
	Route::group(['prefix' => 'masjid'], function () {
		Route::get('get-home-masjid', 'API\MasjidController@index');
		Route::get('get-all-masjid', 'API\MasjidController@getAllMasjid');
		Route::get('detail/{slug}', 'API\MasjidController@getMasjidDetail');
		Route::get('masjid-campaign/{slug}', 'API\UserController@getCampainMasjid');
	});
	/* Route for campaign API */
	Route::group(['prefix' => 'campaign'], function () {
		Route::get('get-detail/{slug}', 'API\CompainController@getCampaignData');
	});
	/* Route for CMS Pages API */
	Route::group(['prefix' => 'page'], function () {
		Route::get('/{slug}', 'API\CmsPageController@getPageBySlug');
	});
});
Route::group(['middleware' => 'auth:api'], function () {
	Route::delete('logout', 'API\AuthController@logout');
	/*
    |----------------------------
    |   Route For User Management
    |----------------------------
    */
	Route::group(['prefix' => 'user'], function () {
		Route::get('/current', 'API\UserController@currentUserDetail');
		Route::post('/update-profile', 'API\UserController@updateUserProfile');
		Route::post('/change-password', 'API\UserController@changeUserPassword');
		Route::post('/update-profile-image', 'API\UserController@updateUserProfileImage');
		Route::get('/my-campain', 'API\UserController@getMasjidAllCampains');
		Route::get('/dashboard','API\UserController@getDashBoardData');
		Route::get('/get-follow-masgid', 'API\UserController@getFollowedMasjid');
		/*
		|----------------------------------------
		| Stripe Management	routes	here
		|----------------------------------------
		*/
		Route::group(['prefix' => 'stripe'], function () {
			// Route::get('connect-stripe-account2', 'API\StripeController@stripeAccountCreate');
			Route::get('/connect-stripe-account', 'API\StripeController@stripeConnectAccountApprove');
		});
	});
	/*
    |---------------------------------
    |   Route For User Role Management
    |---------------------------------
    */
	Route::group(['prefix' => 'role'], function () {
		Route::get('/all', 'API\RoleController@index');
		Route::get('/all-roles', 'API\RoleController@getAllRole');
		Route::post('/create', 'API\RoleController@createRole');
		Route::get('get-role/{id}', 'API\RoleController@getRole');
		Route::post('update/{id}', 'API\RoleController@updateRole');
		Route::delete('delete/{id}', 'API\RoleController@destroy');
	});
	/*
	|-----------------------------------------------
	| Masjid Management	routes	here
	|-----------------------------------------------
	*/
	Route::group(['prefix' => 'masjid'], function () {
		Route::post('/follow-unfollow', 'API\MasjidController@masjidFollowUnFollow');
	});
	/*
	|-----------------------------------------------
	| Masjid Management	routes	here
	|-----------------------------------------------
	*/
	Route::group(['prefix' => 'masjid'], function () {
		Route::post('/follow-unfollow', 'API\MasjidController@masjidFollowUnFollow');
	});
	/*
	|-----------------------------------------------
	| Compains	Management	routes	here
	|-----------------------------------------------
	*/
	Route::group(['prefix' => 'compain'], function () {
		Route::post('create', 'API\CompainController@store');
		Route::post('compain-update', 'API\CompainController@update');
		Route::delete('delete/{id}', 'API\CompainController@destroy');
	});
	/*
	|-----------------------------------------------
	| Masjid Following	Management	routes	here
	|-----------------------------------------------
	*/
	Route::group(['prefix' => 'following'], function () {
		Route::post('/follow-unfollow-Masjid', 'API\MasjidFollowController@store');
		//Route::post('/follow-unfollow-Masjid', 'API\MasjidFollowController@userFollowedMasjid');
		Route::post('getMasjidFollower', 'API\MasjidFollowController@getMasjidFollower');
	});
	/*
	|----------------------------------------
	| Email Tempate	Management	routes	here
	|----------------------------------------
	|-----------------------------------------------
	| Masjid Following	Management	routes	here
	|-----------------------------------------------
	*/
	Route::group(['prefix' => 'email'], function () {
		Route::get('/all', 'API\EmailTemplateController@index');
		Route::post('create', 'API\EmailTemplateController@store');
		Route::get('get/{id}', 'API\EmailTemplateController@show');
		Route::post('update/{id}', 'API\EmailTemplateController@update');
		Route::delete('delete/{id}', 'API\EmailTemplateController@destroy');
	});
});
