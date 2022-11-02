<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Log;

class MessageReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $thread;

    public $newMessage;

    public $recipient;

    public $sender;

    /**
     * Create a new message instance.
     *
     * @param Message $message
     * @param User $recipient
     * @param User $sender
     */
    public function __construct(Message $message, User $recipient, User $sender)
    {
        $this->thread = $message->thread;
        $this->newMessage = $message;
        $this->recipient = $recipient;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), ucwords($this->newMessage->user->name) . ' via ' . ucfirst(env('APP_NAME')))
            ->view('emails.message.received')
            ->subject("Nova poruka - " . $this->thread->subject . " - " . $this->thread->id);
        //    ->to($this->recipient->email);
    }
}
