<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Mail;

class SendVerificationMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whizz:send-verifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually send user email address verification mails.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereVerificationCode(null)->get();

        foreach ($users as $user) {
            $user->verification_code = str_random();
            $user->save();

            $this->output->writeln('Sending mail to ' . $user->email . '...');
            Mail::send('emails.verify', ['token' => $user->verification_code, 'email' => $user->email],
                function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject('Verify your email address.');
                });
        }
    }
}
