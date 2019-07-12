<?php

namespace App\Console;
use DB;
use App\authors;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {

            // DB::table('file_upload_queues')->where('study_id',  Session::get("current_study_id"))->delete();

        })->quarterly();

        $schedule->call('App\Http\Controllers\FileUploadController@dataset_file_upload_queue')
        ->everyMinute();
        $schedule->call('App\Http\Controllers\FileUploadController@key_file_upload_queue')
        ->everyMinute();
        $schedule->call('App\Http\Controllers\FileUploadController@update_signed_url')
        ->daily();
        $schedule->call('App\Http\Controllers\StudyController@permanently_delete_data')
        ->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
