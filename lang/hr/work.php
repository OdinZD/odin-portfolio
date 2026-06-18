<?php

declare(strict_types=1);

// Croatian project case studies, keyed by slug. Titles and client names are not
// translated (handled by the DB columns); status labels come from common.statuses.
return [
    'libra' => [
        'role' => 'Dizajn i izrada',
        'tagline' => 'Topla web stranica vođena ilustracijama za zadarski obrazovni studio koji vodi radionice pripreme za školu za djecu.',
        'body' => "Libra u Zadru vodi radionice i programe pripreme za školu za djecu rane dobi. Trebala im je web stranica koja je topla i razigrana poput same učionice, a istovremeno roditeljima jasno predstavlja programe i olakšava kontakt.\n\nStranicu sam osmislio i izradio od početka do kraja — naslovni dio vođen ilustracijama, pregledan prikaz ponuđenih radionica, priču i vrijednosti studija te obrazac za upit putem kojeg roditelji lako stupaju u kontakt. Stranica je potpuno responzivna i brzo se učitava na mobitelu, gdje je većina roditelja i pronađe.\n\nRezultat je prijateljski i profesionalan nastup koji znatiželjne roditelje pretvara u upite, uz strukturu koju studio može širiti kako dodaje nove radionice i sezonske programe.",
    ],
    'judo-klub-bura' => [
        'role' => 'Dizajn i izrada',
        'tagline' => 'Središte za novosti, raspored i rezultate mladog hrvatskog judo kluba — izrađeno da raste zajedno s ekipom.',
        'body' => "Judo Klub Bura mladi je judo klub na hrvatskoj obali, osnovan 2023. u Ljupču, koji trenira sve od petogodišnjaka do odraslih. Kako je klub prerastao četrdeset članova i počeo osvajati medalje, trebao mu je internetski dom koji može pratiti taj rast.\n\nStranicu sam osmislio i izradio kao živo središte: priču kluba i trenere, raspored treninga, rezultate s natjecanja, novosti kluba te galeriju fotografija koju klub sam ažurira nakon svakog turnira. Sve radi na mobitelu, pa članovi i roditelji termine i rezultate mogu provjeriti u hodu.\n\nStranica klubu daje uvjerljivo javno lice za privlačenje novih članova i sponzora te jednostavan način za slavljenje rezultata i dijeljenje fotografija bez oslanjanja isključivo na društvene mreže.",
    ],
    'cellar' => [
        'role' => 'Dizajn i izrada',
        'tagline' => 'Upravljanje zalihama i blagajna za samostalni vinski bar.',
        'body' => "Kvartovski vinski bar vodio je evidenciju o tristo boca na papiru i gubio novac na bocama koje bi neprimjetno nestale. Trebalo im je rješenje koje osoblje može savladati u jednoj smjeni.\n\nOsmislio sam i izradio POS sustav prilagođen dodiru, s količinama zaliha u stvarnom vremenu, bibliotekom kušačkih bilješki i popisom za naručivanje od dobavljača koji se sam popunjava prema prodaji. Sve radi na iPadu iza šanka.\n\nPopisivanje zaliha koje je nekoć trajalo cijelu večer sada traje dvadeset minuta, a vlasnik napokon dovoljno vjeruje brojkama da prema njima planira vinsku kartu za sljedeću sezonu.",
    ],
    'studioflow' => [
        'role' => 'Samostalna izrada',
        'tagline' => 'Rezervacije, ugovori i plaćanja za fotografski studio.',
        'body' => "Portretni studio svaki je tjedan gubio sate na dopisivanje e-poštom: dogovori datum, potpiši ugovor, plati predujam, i tako ukrug. Administracija je jela vrijeme predviđeno za snimanje.\n\nIzradio sam samoposlužni proces rezervacije u kojem klijenti odaberu termin, potpišu ugovor i plate predujam u jednom koraku. Svaka se rezervacija odmah upisuje u kalendar studija.\n\nStudio je prepolovio administraciju i prestao dvostruko rezervirati vikende — sustav jednostavno ne dopušta da se zauzet termin rezervira dvaput.",
    ],
];
