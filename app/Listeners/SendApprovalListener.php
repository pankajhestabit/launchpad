<?php

namespace App\Listeners;

use App\Events\SendApproval;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendApprovalListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendApproval  $event
     * @return void
     */
    public function handle(SendApproval $event)
    {
        $teacher = User::find($event->teacherId)->toArray();
        Mail::send('emails.approval_email', $teacher, function($message) use ($teacher) {
            $message->to($teacher['email']);
            $message->subject('Profile approval email.');
        });
    }
}
