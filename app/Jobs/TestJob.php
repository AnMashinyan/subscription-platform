<?php
namespace App\Jobs;
use App\Mail\Demomail;
use App\Models\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;



class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $emailsToSent;

    public function __construct($emailsToSent)
    {
        $this ->emailsToSent = $emailsToSent;


    }

    public function handle()
    {
        foreach ($this->emailsToSent as $emailSent) {
            if (Mail::to($emailSent)->send(new DemoMail())) {
                Sender::where('email', $emailSent->email)->update(['is_send' => "1"]);
            }
        }
    }
}
