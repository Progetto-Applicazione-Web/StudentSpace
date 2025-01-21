<?php

namespace App\ESSE3;

enum Endpoint: string
{
    case POLIBA = 'https://poliba.esse3.cineca.it/e3rest/api/';
    case UNIBAS = 'https://unibas.esse3.cineca.it/e3rest/api/';
    case UNIBA = 'https://www.studenti.ict.uniba.it/e3rest/api/';
    case UNIBG = 'https://sportello.unibg.it/e3rest/api/';
    case UNIBS = 'https://esse3.unibs.it/e3rest/api/';
    case UNICAL = 'https://unical.esse3.cineca.it/e3rest/api/';
    case UNICAMPANIA = 'https://esse3.cressi.unicampania.it/e3rest/api/';
    case UNICAMPUS = 'https://didattica.unicampus.it/e3rest/api/';
    case UNICAM = 'https://didattica.unicam.it/e3rest/api/';
    case UNICA = 'https://unica.esse3.cineca.it/e3rest/api/';
    case UNICH = 'https://unich.esse3.cineca.it/e3rest/api/';
    case UNIFI = 'https://studenti.unifi.it/e3rest/api/';
    case UNIMARCONI = 'https://unimarconi.esse3.cineca.it/e3rest/api/';
    case UNIME = 'https://unime.esse3.cineca.it/e3rest/api/';
    case UNIMIB = 'https://s3w.si.unimib.it/e3rest/api/';
    case UNIMORE = 'https://www.esse3.unimore.it/e3rest/api/';
    case UNINSUBRIA = 'https://uninsubria.esse3.cineca.it/e3rest/api/';
    case UNIPG = 'https://unipg.esse3.cineca.it/e3rest/api/';
    case UNIPI = 'https://www.studenti.unipi.it/e3rest/api/';
    case UNIPR = 'https://unipr.esse3.cineca.it/e3rest/api/';
    case UNIPV = 'https://studentionline.unipv.it/e3rest/api/';
    case UNIRSM = 'https://unirsm.esse3.cineca.it/e3rest/api/';
    case UNISANNIO = 'https://unisannio.esse3.cineca.it/e3rest/api/';
    case UNITN = 'https://www.esse3.unitn.it/e3rest/api/';
    case UNITO = 'https://esse3.unito.it/e3rest/api/';
    case UNITS = 'https://esse3.units.it/e3rest/api/';
    case UNIUD = 'https://uniud.esse3.cineca.it/e3rest/api/';
    case UNIURB = 'https://uniurb.esse3.cineca.it/e3rest/api/';
    case UNIVAQ = 'https://univaq.esse3.cineca.it/e3rest/api/';
    case UNIVE = 'https://esse3.unive.it/e3rest/api/';
    case UNIVPM = 'https://univpm.esse3.cineca.it/e3rest/api/';

    public function getDescription(): string
    {
        return match($this) {
            self::POLIBA => 'Politecnico di Bari',
            self::UNIBAS => 'Università degli Studi della Basilicata',
            self::UNIBA => 'Università degli Studi di Bari Aldo Moro',
            self::UNIBG => 'Università degli Studi di Bergamo',
            self::UNIBS => 'Università degli Studi di Brescia',
            self::UNICAL => 'Università della Calabria',
            self::UNICAMPANIA => 'Università degli Studi della Campania Luigi Vanvitelli',
            self::UNICAMPUS => 'Università Campus Bio-Medico di Roma',
            self::UNICAM => 'Università di Camerino',
            self::UNICA => 'Università degli Studi di Cagliari',
            self::UNICH => 'Università degli Studi G. D\'Annunzio Chieti Pescara',
            self::UNIFI => 'Università degli Studi di Firenze',
            self::UNIMARCONI => 'Università degli Studi Guglielmo Marconi',
            self::UNIME => 'Università degli Studi di Messina',
            self::UNIMIB => 'Università degli Studi di Milano-Bicocca',
            self::UNIMORE => 'Università degli Studi di Modena e Reggio Emilia',
            self::UNINSUBRIA => 'Università degli Studi dell\'Insubria',
            self::UNIPG => 'Università degli Studi di Perugia',
            self::UNIPI => 'Università di Pisa',
            self::UNIPR => 'Università di Parma',
            self::UNIPV => 'Università degli Studi di Pavia',
            self::UNIRSM => 'Università degli Studi della Repubblica di San Marino',
            self::UNISANNIO => 'Università degli Studi del Sannio',
            self::UNITN => 'Università degli Studi di Trento',
            self::UNITO => 'Università di Torino',
            self::UNITS => 'Università degli Studi di Trieste',
            self::UNIUD => 'Università degli Studi di Udine',
            self::UNIURB => 'Università degli Studi di Urbino Carlo Bo',
            self::UNIVAQ => 'Università degli Studi dell\'Aquila',
            self::UNIVE => 'Università Ca\' Foscari Venezia',
            self::UNIVPM => 'Università Politecnica delle Marche',
        };
    }
}
