<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Demomail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct()
    {
    }

    public function build()
    {
        $post = DB::table('posts')->latest('id')->first(); //it is used in mails.demoMail file
        return $this->subject('Send email to new subscribers')
        ->view('emails.demoMail',compact('post'));
    }
}
