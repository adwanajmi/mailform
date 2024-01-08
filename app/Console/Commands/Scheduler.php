<?php

namespace App\Console\Commands;

use App\Mail\eFORMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Scheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eform:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'eFORM Scheduler';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $currentDateTime = now()->format('Y-m-d H:i:s');

    //     $this->info('Loading...');

    //     // Query untuk dapatkan pending case dan pending kat siapa

    //     $users = DB::table('app_delegation')
    //         ->join('application', 'app_delegation.APP_NUMBER', '=', 'application.APP_NUMBER')
    //         ->join('users', 'users.USR_ID', '=', 'app_delegation.USR_ID')
    //         ->select(
    //             'users.USR_LASTNAME',
    //             'users.USR_EMAIL',
    //             'application.APP_NUMBER',
    //             'app_delegation.DEL_DELEGATE_DATE'
    //         )
    //         ->where('app_delegation.DEL_LAST_INDEX', 1)
    //         ->where('app_delegation.del_thread_status', 'open')
    //         ->where('app_delegation.PRO_UID', '9181518555930bd3c5c17c3003883186')
    //         ->where('application.APP_STATUS', 'to_do')
    //         ->where('application.PRO_UID', '9181518555930bd3c5c17c3003883186')
    //         ->limit(1)
    //         ->get();

    //     foreach ($users as &$user) {
    //         $user->USR_EMAIL = 'adwa.rosmadi@swmsb.com';
    //     }

    //     dd($users);

    //     foreach ($users as $user) {
    //         Mail::to($user->USR_EMAIL)->send(new eFORMail($user));
    //     }

    //     $this->info("Finished and sucessful: $currentDateTime");

    // }

    public function handle()
    {
        $this->info('Loading...');

        $users = DB::table('app_delegation')
            ->join('application', 'app_delegation.APP_NUMBER', '=', 'application.APP_NUMBER')
            ->join('users', 'users.USR_ID', '=', 'app_delegation.USR_ID')
            ->join('pmt_case_detail', 'app_delegation.APP_NUMBER', '=', 'pmt_case_detail.APP_NUMBER')
            ->select(
                'users.USR_LASTNAME',
                'users.USR_EMAIL',
                'application.APP_NUMBER',
                'app_delegation.DEL_DELEGATE_DATE',
                'pmt_case_detail.TXT_DOC'
            )
            ->where('app_delegation.DEL_LAST_INDEX', 1)
            ->where('app_delegation.del_thread_status', 'open')
            ->where('app_delegation.PRO_UID', '9181518555930bd3c5c17c3003883186')
            ->where('application.APP_STATUS', 'to_do')
            ->where('application.PRO_UID', '9181518555930bd3c5c17c3003883186')
            ->where('app_delegation.TAS_UID', '5616149905930bd3c738e27075412233')
            ->where('app_delegation.DEL_DELEGATE_DATE', '<', DB::raw('DATE_SUB(NOW(), INTERVAL 3 DAY)'))
            ->get();

        // foreach ($users as &$user) {
        //     $user->USR_EMAIL = 'adwa.rosmadi@swmsb.com';
        // }

        $groupedUsers = $users->groupBy('USR_LASTNAME');

        $groupedUsers->each(function ($userGroup) {
            $userData = (object) [
                'USR_LASTNAME' => $userGroup->first()->USR_LASTNAME,
                'USR_EMAIL' => $userGroup->first()->USR_EMAIL,
                'APP_NUMBERS' => $userGroup->pluck('APP_NUMBER')->toArray(),
                'DATES' => $userGroup->pluck('DEL_DELEGATE_DATE')->toArray(),
                'TXT_DOCS' => $userGroup->pluck('TXT_DOC')->toArray(),
            ];

            Mail::to($userData->USR_EMAIL)->send(new eFORMail($userData));
        });

        $currentDateTime = now()->format('Y-m-d H:i:s');
        $this->info("Finished and successful: $currentDateTime");
    }

}
