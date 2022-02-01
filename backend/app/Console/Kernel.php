<?php

namespace App\Console;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\serveCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            /**
             * Cek user yang belum terverifikasi diatas 6 jam.
             * Jika ada, delete user tersebut.
             * 
             */
            User::where('email_verified', '!=', 'verified')
                ->where(
                    'created_at',
                    '<=',
                    Carbon::now()->subSeconds(config('auth.verify_max'))
                )
                ->delete();
        })->everyMinute();
    }
}
