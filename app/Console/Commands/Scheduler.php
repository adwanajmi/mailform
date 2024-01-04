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

    //     foreach ($users as $user) {
    //         Mail::to($user->USR_EMAIL)->send(new eFORMail($user));
    //     }

    //     $this->info('Done.');

    // }

    public function handle()
    {
        $this->info('Loading...');

        // Trigger email reminder lebih dari 3 hari

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
            ->get();

        foreach ($users as &$user) {
            $user->USR_EMAIL = 'adwa.rosmadi@swmsb.com';
        }


        // dd($users);
        // Group users by their last name
        $groupedUsers = collect([]);

        foreach ($users as $user) {
            // Use the last name as the key for grouping
            $lastName = $user->USR_LASTNAME;

            if (!$groupedUsers->has($lastName)) {
                $groupedUsers[$lastName] = (object) [
                    'USR_LASTNAME' => $lastName,
                    'USR_EMAIL' => $user->USR_EMAIL,
                    'APP_NUMBERS' => [],
                    'DATES' => [],
                    'TXT_DOCS' => [],
                ];
            }

            // Append data to the existing user group
            $groupedUsers[$lastName]->APP_NUMBERS[] = $user->APP_NUMBER;
            $groupedUsers[$lastName]->DATES[] = $user->DEL_DELEGATE_DATE;
            $groupedUsers[$lastName]->TXT_DOCS[] = $user->TXT_DOC;
        }

        // dd($groupedUsers);

        foreach ($groupedUsers as $userData) {
            // Use Mail facade to send an email
            Mail::to($userData->USR_EMAIL)->send(new eFORMail($userData));
        }

        $this->info('Done.');
    }

}
