<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
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
            $len = Redis::llen('plan');
            if ($len > 0) {
               for ($i=0; $i < $len ; $i++) {
                    $data = unserialize(Redis::rpop('plan'));
                    $res = DB::table('plan')->insertGetId(['content'=>$data['content'],'add_time'=>$data['add_time'],'ti_time'=>$data['time'],'user_id'=>$data['user_id']]);
                }
            }
        })->everyMinute();
    }
}
