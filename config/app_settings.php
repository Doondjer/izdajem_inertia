<?php

return [
    'values' => [
        'card_media_left_title' => 'Pronađite sledeće stanare',
        'card_media_left_content' => 'Izdajem.rs vam omogućava da oglasite izdavanje vašeg stana, sobe ili kuće na mestu koje svakog meseca posećuje veliki broj stanara.
                            Sa budućim stanarima možete komunicirati putem našeg sistema poruka ili ostaviti vaš broj telefona.
                            Pored toga ukoliko vam neko pošalje poruku putem Izdajem.rs dobićete sms sa obaveštenjem na vaš telefon, sve sa ciljem da vam pomognemo da brzo pronađete i proverite kandidate.',
        'card_media_left_jpg' => 'couple_apartment.jpg',
        'card_media_left_webp' => 'couple_apartment.webp',
        'card_media_right_title' => 'Pronađi pravi stan za sebe',
        'card_media_right_content' => 'Ne postoji dom koji odgovara svima. Da li tražiš nešto posebno kod stana koji ćeš iznajmiti? Proveri stanove kuće i sobe koje su drugi članovi postavili kod nas.',
        'card_media_right_jpg' => 'couple_searching.jpg',
        'card_media_right_webp' => 'couple_searching.webp',
        'footer_info_text' => 'Izdajem.rs je mesto za pretragu i postavljanje oglasa za izdavanje nekretnina. Ukoliko posedujete višak stambenog prostora u vidu stana, sobe, poslovnog prostora ili ste prosto profesionalac kome je to posao, na Izdajem.rs možete postaviti vaš oglas za izdavanje stana brzo i lako.
                                Sa druge strane ukoliko ste stanar i tražite da iznajmite stan, kuću ili poslovni prostor Izdajem.rs je pravo mesto za vas. Pogledajte šta su vlasnici i stanodavci ponudili na Izdajem.rs i stupite u kontak sa njima.',
        'home_title' => 'Iznajmi stan, sobu ili kuću koju ćeš voleti.',
        'home_subtitle' => 'Pretraži stanove i kuće za izdavanje u Srbiji.',
        'image_base_route' => env('APP_URL') . '/images',
        'listing_default_image' => 'picture-not-available.jpg',
        'default_profile_image' => 'default-avatar.jpg',
        'listing_default_image_webp' => 'picture-not-available.webp',
        'maximum_images'   => 20, // Promeniti i u frontendu
        'main_image' => 'main-large.jpg',
        'meta_description' => 'Izdajem.rs je oglasnik za izdavanje nekretnina u Srbiji. Oglasite izdavanje vašeg stana, kuće, poslovnog prostora ili pronađite prave stanare za vašu nekretninu.',
        'create_meta_description' => 'Tražite gde da oglasite izdavanje vaše nekretnine? Vlasnici mogu veoma brzo pronaći stanare za stan, kuću ili poslovni prostor direktnim oglašavanjem na izdajem.rs',
        'meta_keywords' => '',
        'threads_paginate_by' => 10,
        'paginate_allowed' => [ 3, 5, 10, 20, 50 ],
        'paginate_default' => 10,
        'sms_code_length' => 6,
        'send_sms_throttle' => 1,// in minutes default 5
        'main_image_webp' => 'main-large.webp',
        'slider_tile'   => 'Poslednji stanovi oglašeni za izdavanje na Izdajem.rs',
        'enable_google_analytics' => false,
        'enable_mouseflow' => false,
        'social' => [
            'facebook' => [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'url' => 'https://www.facebook.com/izdajem.rs/',
                ],
            'twitter' => [
                'name' => 'Twitter',
                'icon' => 'twitter',
                'url' => 'https://twitter.com/izdajem',
                ],
        ],
        'types' => [
            'stan' => 'Stan',
            'kuca' => 'Kuća',
            'stan-u-kuci' => 'Stan u kući',
            'poslovni-prostor' => 'Poslovni prostor',
        ],
        'furnish_types' => [
            'namesten' => 'Namešten',
            'polunamesten' => 'Polunamešten',
            'nenamesten' => 'Nenamešten',
        ],
        'structure' => [
            '0.5' => 'Garsonjera',
            '1.0' => 'Jednosoban',
            '1.5' => 'Jednoiposoban',
            '2.0' => 'Dvosoban',
            '2.5' => 'Dvoiposoban',
            '3.0' => 'Trosoban',
            '3.5' => 'Troiposoban',
            '4.0' => 'Četvorosoban',
            '4.5' => 'Četvoroiposoban',
            '5.0' => 'Petosoban i veći'
        ],
        'statuses' => [
            'published' => 'Objavljen',
            'draft' => 'Parkiran',
            'rented' => 'Iznajmljen',
            'created' => 'Nedovršen'
        ]
    ],

];
