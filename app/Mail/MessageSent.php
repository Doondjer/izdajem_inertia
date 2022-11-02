<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Foundation\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $thread;

    public $newMessage;

    public $sender;

    /**
     * Create a new message instance.
     *
     * @param Message $message
     * @param User $recipient
     */
    public function __construct(Message $message, User $sender)
    {
        $this->thread = $message->thread;
        $this->newMessage = $message;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), ucwords($this->sender->name) . ' via ' . ucfirst(env('APP_NAME')))
            ->view('emails.message.sent')
            ->subject("Nova poruka - " . $this->thread->subject . " - " . $this->thread->id);
          //  ->to($this->newMessage->user->email);
    }
}
