<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}




/**
 * -----------------------------------------------------------------------------
 * Create The Application
 * -----------------------------------------------------------------------------
 * 
 * Di sini kita akan memuat environment dan membuat instance aplikasi
 * yang berfungsi sebagai bagian utama dari framework ini.
 * 
 */

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();
$app->withEloquent();

$app->withFacades(true, [
    'Illuminate\Support\Facades\Notification' => 'Notification',
]);




/**
 * -----------------------------------------------------------------------------
 * Register Container Bindings
 * -----------------------------------------------------------------------------
 * 
 * Sekarang kita akan mendaftarkan beberapa binding pada service container.
 * Kita akan daftarkan exception handler dan kernel console. Kamu dapat
 * menambahkan binding kamu sendiri di sini atau kamu dapat membuat
 * file lain.
 * 
 */

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


$app->configure('cors');



/**
 * -----------------------------------------------------------------------------
 * Register Middleware
 * -----------------------------------------------------------------------------
 * 
 * Selanjutnya, kita akan mendaftarkan middleware pada aplikasi. Bisa berupa
 * middleware global yang berjalan sebelum dan sesudah setiap request
 * menjadi satu route atau middleware yang akan ditetapkan ke
 * beberapa route tertentu.
 * 
 */

// Middleware global
$app->middleware([
    // App\Http\Middleware\ExampleMiddleware::class
    Spatie\Cors\Cors::class,
]);

// Middleware route, non-global
$app->routeMiddleware([
    'guest' => App\Http\Middleware\GuestMiddleware::class,
    'authenticated' => App\Http\Middleware\AuthenticatedMiddleware::class,
    'verified-email' => App\Http\Middleware\VerifiedEmailMiddleware::class,
    'unverified-email' => App\Http\Middleware\UnverifiedEmailMiddleware::class,

    'admin' => App\Http\Middleware\AdminMiddleware::class,
    'moderator' => App\Http\Middleware\ModeratorMiddleware::class,

]);




/**
 * -----------------------------------------------------------------------------
 * Register Service Providers
 * -----------------------------------------------------------------------------
 * Di sini kita akan mendaftarkan semua service provider aplikasi yang
 * digunakan untuk binding service ke dalam container. Service provider
 * sangat opsional, jadi kamu tidak perlu menghapus komentar pada baris ini.
 * 
 */

$app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Jenssegers\Agent\AgentServiceProvider::class);
$app->register(Spatie\Cors\CorsServiceProvider::class);
$app->register(\Illuminate\Notifications\NotificationServiceProvider::class);




/**
 * -----------------------------------------------------------------------------
 * Load The Application Routes
 * -----------------------------------------------------------------------------
 * 
 * Selanjutnya kita akan menyertakan file route. Ini akan mengambil semua
 * URL aplikasi yang dapat merespon, serta controller yang memprosesnya.
 * 
 */

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});




/**
 * -----------------------------------------------------------------------------
 * Load The Configuration Files
 * -----------------------------------------------------------------------------
 * 
 * Selanjutnya kita akan menyertakan file konfigurasi. Ini akan mengambil semua
 * konfigurasi aplikasi pada folder /config.
 * 
 */

collect(scandir(__DIR__ . '/../config'))->each(function ($item) use ($app) {
    $app->configure(basename($item, '.php'));
});




/**
 * -----------------------------------------------------------------------------
 * Execute The Application
 * -----------------------------------------------------------------------------
 * 
 * */

return $app;
