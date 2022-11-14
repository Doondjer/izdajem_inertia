<?php namespace App\Acme\Traits;

use App\Models\User;

trait UserSettingsTrait {

    public function getValues(User $user)
    {
        return [
            'email_notify_message_sent'     => $user->email_notify_message_sent,
            'email_notify_message_received' => $user->email_notify_message_received,
            'email_notify_listing_created'  => $user->email_notify_listing_created,
            'sms_notify_message_received'   => $user->sms_notify_message_received,
            'show_profile'                  => $user->show_profile,
        ];
    }

    public function getSettings(User $user)
    {
        return [
            'Obaveštenja' => [
                [
                    'title' => 'Poslate poruke',
                    'on' => 'email',
                    'name' => 'email_notify_message_sent',
                    'value' => $user->email_notify_message_sent,
                    'description' => 'Omogućite slanje obaveštenja na vaš email, kada pošaljete novu poruku drugom korisniku putem našeg sistema poruka.'
                ],
                [
                    'title' => 'Primljene poruke',
                    'on' => 'email',
                    'name' => 'email_notify_message_received',
                    'value' => $user->email_notify_message_received,
                    'description' => 'Omogućite slanje obaveštenja na vaš email, kada vam stigne nova poruka od korisnika putem našeg sistema poruka.'
                ],
                [
                    'title' => 'Postavljanje nekretnine',
                    'on' => 'email',
                    'name' => 'email_notify_listing_created',
                    'value' => $user->email_notify_listing_created,
                    'description' => 'Omogućite slanje obaveštenja na email sa linkom i detaljima vašeg oglasa, kada postavite novu nekretninu za izdavanje.'
                ],
                [
                    'title' => 'Primljene poruke',
                    'on' => 'sms',
                    'name' => 'sms_notify_message_received',
                    'value' => $user->sms_notify_message_received,
                    'description' => 'Omogućite slanje obaveštenja putem SMS, na vaš broj telefona, kada vam stigne nova poruka od korisnika putem našeg sistema poruka.',
                    'notice' => $user->isPhoneVerified() ? '' : 'Morate imati verifikovan broj telefona u sekciji "Moj Profil"!',
                    'disabled' => ! $user->isPhoneVerified()
                ],
            ],
            'Podešavanja' => [
                [
                    'title' => 'Omogući profil',
                    'name' => 'show_profile',
                    'on' => 'Izdajem.rs',
                    'value' => $user->show_profile,
                    'description' => 'Omogućite prikazivanje stranice vašeg profila drugim korisnicima.'
                ],
            ]
        ];
    }
}
