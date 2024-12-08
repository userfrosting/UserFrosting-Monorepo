<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

return [
    'USERNAME' => 'Nom d\'utilisateur', //Note the espace `\` caracter here. Won't be displayed in the test

    //"BASE_FALLBACK" => "Langue de secours", //We want to test if the english string will be displayed here

    'ACCOUNT' => [
        '@TRANSLATION' => "Compte de l'utilisateur", //Don't need to escape if using double quote `"`
        'ALT'          => 'Profil',
    ],

    'GROUP' => [
        1 => 'Groupe',
        2 => 'Groupes',

        'CREATE' => 'Créer groupe',
    ],

    // Colors
    'COLOR' => [
        //Substrings
        'BLACK' => 'noir',
        'RED'   => 'rouge',
        'WHITE' => 'blanc',

        //Plurals
        0 => 'couleur',
        1 => 'couleur',
        2 => 'couleurs',
    ],

    // Cars
    'CAR' => [
        //Plurals
        1 => 'voiture',
        2 => 'voitures',

        //Substrings
        'GAS' => 'à essence',
        'EV'  => [
            //"@TRANSLATION" => "électrique", //Can't work for french !
            // But since French is loaded on top to English and English have this one defined
            // it will return the english string if we want to translate "EV" without a plural value.
            // So we need to get rid of the English string :
            '@TRANSLATION' => null,

            //We will pluralize instead
            1 => 'électrique',
            2 => 'électriques',

            //Sub-Substring
            'FULL'          => '100% électrique',
            'HYBRID'        => 'hybride',
            'PLUGIN_HYBRID' => 'hybride branchable',
        ],
        'HYDROGEN' => "à l'hydrogène",
    ],
    'X_CARS' => [
        0 => 'aucune voiture',
        1 => 'une voiture',
        2 => '{{plural}} voitures',
    ],

    // Placeholder strings
    'MY_CAR_STRING' => 'Je conduit une {{my_car}} de couleur {{color}}',
    'MY_CAR_MAKE'   => 'Ma voiture est une {{car_make}}',
    'MY_CAR_YEAR'   => "J'ai acheté ma voiture en {{year}}",
    'MY_CARS'       => "J'ai {{x_cars}}",

    // Plural with placeholder
    'MY_EV_CARS' => [
        '@TRANSLATION' => 'Mes voitures électriques',
        1              => 'Le chat a une {{&CAR}} {{type}}',
        2              => 'Le chat a {{plural}} {{&CAR}} {{type}}',
    ],

    // Custom plural key with no "zero" case.
    // In english, "2" should be used when the plural value is zero. In french, "1" should be used
    'X_HUNGRY_CATS' => [
        '@PLURAL' => 'num',
        1         => '{{num}} chat affamé',
        2         => '{{num}} chats affamés',
    ],

    // Min/max placeholder where the
    'TEST_LIMIT' => 'Votre test doit être entre {{min}} et {{max}} patates.',
    'MIN'        => 'minimum',
    //"MAX" => "maximum" //Leave disabled for tests

    // Empty array
    'EMPTY' => [

    ],

    // Missing one rule
    'X_RULES' => [
        0 => 'aucune règle',
        1 => '{{plural}} règle',
        //2 => '{{plural}} règles', //Leave disabled for tests
    ],

    // Missing all rules
    'X_BANANAS' => [
        0 => 'aucune banane',
        //1 => '{{plural}} banane', //Leave disabled for tests
        //2 => '{{plural}} bananes', //Leave disabled for tests
    ],

    // No rules are followed
    'X_DOGS' => [
        5      => 'cinq chiens',
        101    => '101 Dalmatiens',
        '1000' => 'Une tempête de chiens',
    ],

    // keys as strings
    'X_TABLES' => [
        '0' => 'aucune table',
        '1' => 'une table',
        '2' => '{{plural}} tables',
    ],
];
