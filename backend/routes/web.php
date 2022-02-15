<?php

/**
 * -----------------------------------------------------------------------------
 * Application Routes
 * -----------------------------------------------------------------------------
 * 
 * Di sinilah tempat mendaftarkan semua rute untuk API endpoints.
 * Cukup beri tahu Lumen URL yang harus ditanggapi beserta metode request, 
 * kemudian berikan controller untuk mengelola proses URL yang diminta.
 * 
 */





use Illuminate\Support\Facades\Artisan;




/**
 * Halaman Utama API
 * -----------------------------------------------------------------------------
 */

$router->get('/', function () use ($router) {
    $response = "Robotika UNS API   <br>" . $router->app->version();
    return $response;
});




/**
 * Authentication Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'auth'], function () use ($router) {

    // Login
    $router->post('login', [
        'uses' => 'AuthController@authenticate',
        'middleware' => 'guest'
    ]);

    // /Register
    $router->post('register', [
        'uses' => 'AuthController@register',
        'middleware' => 'guest'
    ]);

    // Verifiy Email
    $router->post('verify', [
        'uses' => 'AuthController@verify',
        'middleware' => ['authenticated', 'unverified-email']
    ]);

    // Resend Email
    $router->patch('resend', [
        'uses' => 'AuthController@resend',
        'middleware' => ['authenticated', 'unverified-email']
    ]);

    // Resend Email Get Cooldown
    $router->get('resend/cooldown', [
        'uses' => 'AuthController@resendGetCooldown',
        'middleware' => ['authenticated', 'unverified-email']
    ]);

    // Logout
    $router->delete('logout', [
        'uses' => 'AuthController@logout',
        'middleware' => 'authenticated'
    ]);

    // Who am I?
    $router->get('whoami', [
        'uses' => 'AuthController@whoami',
        'middleware' => 'authenticated'
    ]);
});




/**
 * User Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'user'], function () use ($router) {

    // Ambil data user.
    $router->get('/get/{username}', [
        'uses' => 'UserController@getUserByUsername',
    ]);

    // Update role user.
    $router->patch('/role', [
        'uses' => 'UserController@changeRole',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator'
        ]
    ]);

    // Update data user.
    $router->patch('/', [
        'uses' => 'UserController@update',
        'middleware' => ['authenticated', 'verified-email']
    ]);

    // Update foto user.
    $router->post('/photo', [
        'uses' => 'UserController@photo',
        'middleware' => ['authenticated', 'verified-email']
    ]);

    // Cari user.
    $router->get('/', [
        'uses' => 'UserController@search',
    ]);
});

$router->group(['prefix' => 'users'], function () use ($router) {
});




/**
 * Recruitment Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'recruit'], function () use ($router) {

    // Create Recruit
    $router->post('/', [
        'uses' => 'RecruitController@create',
        'middleware' => ['authenticated', 'verified-email']
    ]);

    // Read Recruit
    $router->get('/', [
        'uses' => 'RecruitController@read',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);

    // Check Recruit
    $router->get('check', [
        'uses' => 'RecruitController@check',
        'middleware' => ['authenticated', 'verified-email']
    ]);

    // Terima Recruit
    $router->patch('/terima', [
        'uses' => 'RecruitController@terima',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);

    // Tolak Recruit
    $router->patch('/tolak', [
        'uses' => 'RecruitController@tolak',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);

    // Finalize Recruit
    $router->post('/finalize', [
        'uses' => 'RecruitController@finalize',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);
});




/**
 * Journey Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'journey'], function () use ($router) {

    // Buat Journey
    $router->post('/', [
        'uses' => 'JourneyController@create',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);

    // Ambil Journey berdasarkan user
    $router->get('user/{user_id}', [
        'uses' => 'JourneyController@getJourneyByUser',
    ]);
});




/**
 * Notification Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'notifications'], function () use ($router) {

    // Ambil notifikasi untuk user saat ini.
    $router->get('/', [
        'uses' => 'NotificationController@getAll',
        'middleware' => [
            'authenticated', 'verified-email',
            'roles:administrator|moderator'
        ]
    ]);
});




/**
 * Log Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'log'], function () use ($router) {

    // Ambil semua log.
    $router->get('/', [
        'uses' => 'LogController@read',
        'middleware' => ['authenticated', 'verified-email']
    ]);
});




/**
 * Setting Routes
 * -----------------------------------------------------------------------------
 */

$router->group(['prefix' => 'setting'], function () use ($router) {

    // Set pengaturan.
    $router->patch('/set', [
        'uses' => 'SettingController@set',
        'middleware' => ['authenticated', 'verified-email']
    ]);

    // Ambil pengaturan.
    $router->get('/get', [
        'uses' => 'SettingController@get',
    ]);
});




/**
 * Deploy Routes
 * -----------------------------------------------------------------------------
 */
$router->group(['prefix' => 'deploy'], function () use ($router) {

    // Migrating table.
    $router->post('/migrate', function () use ($router) {
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        return response()->json([
            'message' => 'Database migrated!'
        ], 200);
    });
});
