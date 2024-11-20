<?php

namespace App\Console\Commands;

use App\Mail\WelcomeMailable;
use Illuminate\Console\Command;

class SendWelcomeEmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-welcome-email-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        //
        #app(\App\Mail\WelcomeMailable::class)->send();
        $merchant = [
            'name' => 'Saad Alam',
            'email' => 'test@mail.com',
            'app_name' => "WA Qinwuiryt",
            'teamName' => "Team Codeinnovers"
        ];
        \Mail::to($merchant['email'])->send(new WelcomeMailable($merchant));
    }
}
