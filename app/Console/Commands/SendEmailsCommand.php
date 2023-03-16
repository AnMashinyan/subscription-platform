<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use App\Models\Sender;
use Illuminate\Console\Command;


class SendEmailsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Sender::select('id', 'email')->where("is_send", "0")->chunkById(1000, function ($emailsToSent) {

            TestJob::dispatch($emailsToSent);

        });

    }
}




