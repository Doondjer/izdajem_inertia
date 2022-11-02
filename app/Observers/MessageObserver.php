<?php

namespace App\Observers;

use App\Acme\LaraTwilio;
use App\Mail\MessageReceived;
use App\Mail\MessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        if($message->thread && $message->thread->participants) {
            foreach ($message->thread->participants as $participant) {
                try {
                    if(Auth::id() == $participant->user->id && $participant->user->email && $participant->user->email_notify_message_sent){
                        Mail::to($participant->user->email)->send(new MessageSent($message, $participant->user));
                    } else {

                        if ($participant->user->email && $participant->user->email_notify_message_received){
                            Mail::to($participant->user->email)->send(new MessageReceived($message, $participant->user, Auth::user()));
                        }

                        if($participant->user->isPhoneVerified() && $participant->user->sms_notify_message_received) {
                            $twilio = app()->make(LaraTwilio::class);
                            $twilio->notify($participant->user->phone, "'Poštovani, imate nove poruke na " . env('APP_NAME') . ". Možete ih proveriti na " . route('message.index'));
                        }
                    }

                } catch (\Exception $e) {
                    report($e);
                }
            }
        }

    }
}
