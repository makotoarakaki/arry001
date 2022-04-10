<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\MailStand;
use App\User;
use App\Mail\SendMail;
use App\SearchUser;

class RegularEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reguler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email registered in the schedule';

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
        $d = new DateTime();
        $now = $d->modify('+9 hour')->format('Y-m-d H:i');

        $task = MailStand::where('send_datetime','=', $now)->first();
        if (!is_null($task)) {
            // 全ユーザー取得
            if ($task->send == 3) {
                $users = SearchUser::where('mail_stand_id', '=', $task->id)->get();
            } else {
                $users = User::all();
            }
            foreach($users as $user) {
                Mail::send(new SendMail($user->email, $user->name, $task->title, $task->comment));
            }
        }
    }
}
