<?php

return [
    [
        'id' => 1,
        'title' => 'Koliko dugo ce se oglas prikazivati na izdajem.rs?',
        'message' => 'Vaš oglas za izdavanje će se pojavljivati na ' . env('APP_NAME') . ' dok ne pronađete stanara, obrišete oglas ili dok ne istekne mesec dana od dana objavljivanja.
                        Vi imate punu kontrolu nad vašim oglasom i veoma lako možete da ga skinete ukoliko pronađete stanara: samo se Ulogujte i posetite "<a href="' . route("user-listing.index") . '" class="uk-link">Moje nekretnine</a>" deo.',
    ],
    [
        'id' => 2,
        'title' => 'Koje vrste oglasa postoje na izdajem.rs?',
        'message' => 'Na izdajem.rs trenutno postoji samo standardni oglas koji se pojavljuje u rezultatima pretrage poređan po datumu objavljivanja. U planu su Premium, Istaknuti i oglas koji će se pojavljivati po redosledu iznad standardnih a uvođenje će zavisiti od interesovanja.',
    ],
    [
        'id' => 3,
        'title' => 'Da li mogu da menjam oglas posle objavljivanja?',
        'message' => 'Da možete da menjate opis, slike, cenu i sve ostale detalje oglasa osim adrese na kojoj se nekretnina nalazi. Samo se Ulogujte i posetite "<a href="' . route("user-listing.index") . '" class="uk-link">Moje nekretnine</a>" deo i možete da izmenite oglas  u bilo koje vreme.',
    ],
    [
        'id' => 4,
        'title' => 'Da li mogu da nadogradim oglas da se prikazuje iznad ostalih u rezultatima pretrage?',
        'message' => 'Trenutno je moguće odabrati samo standardan oglas za izdavanje nekretnina. Pošaljite nam <a href="' . route("contact-us.show") . '" class="uk-link">poruku</a> ukoliko ste zainteresovani za neku vrstu promocije, uvođenje će zavisiti od interesovanja.',
    ],
];
