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




use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\User;
use Carbon\Carbon;

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
    $router->get('verify', [
        'uses' => 'AuthController@verify',
    ]);

    // Resend Email
    $router->patch('resend', [
        'uses' => 'AuthController@resend',
        'middleware' => 'unverified-email'
    ]);

    // Logout
    $router->post('logout', [
        'uses' => 'AuthController@logout',
        'middleware' => 'authenticated'
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
