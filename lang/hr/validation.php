<?php

declare(strict_types=1);

// Croatian messages for the rules the contact form uses. Any key not present here
// falls back to the English file (fallback_locale = en).
return [
    'required' => 'Polje :attribute je obavezno.',
    'email' => 'Polje :attribute mora biti ispravna e-mail adresa.',
    'string' => 'Polje :attribute mora biti tekst.',

    'min' => [
        'string' => 'Polje :attribute mora sadržavati najmanje :min znakova.',
        'numeric' => 'Polje :attribute mora biti najmanje :min.',
        'array' => 'Polje :attribute mora sadržavati najmanje :min stavki.',
        'file' => 'Polje :attribute mora biti najmanje :min kilobajta.',
    ],

    'max' => [
        'string' => 'Polje :attribute ne smije biti dulje od :max znakova.',
        'numeric' => 'Polje :attribute ne smije biti veće od :max.',
        'array' => 'Polje :attribute ne smije sadržavati više od :max stavki.',
        'file' => 'Polje :attribute ne smije biti veće od :max kilobajta.',
    ],

    'attributes' => [
        'name' => 'ime',
        'email' => 'e-pošta',
        'subject' => 'predmet',
        'message' => 'poruka',
    ],
];
