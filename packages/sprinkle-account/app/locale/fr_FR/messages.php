<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

/**
 * French message token translations for the 'account' sprinkle.
 *
 * @author Louis Charette
 */
return [
    'ACCOUNT' => [
        '@TRANSLATION'        => 'Compte d\'utilisateur',

        'EXCEPTION' => [
            'TITLE'       => 'Account Exception',
            'DESCRIPTION' => 'An unspecified error with he account has been encountered.',

            'ACCESS_DENIED' => [
                'TITLE'       => 'Access Denied',
                'DESCRIPTION' => 'Hmm, on dirait que vous n\'avez pas la permission de faire ceci.',
            ],
            'DISABLED' => [
                'TITLE'       => 'Account Disabled',
                'DESCRIPTION' => 'Ce compte a été désactivé. Veuillez nous contacter pour plus d\'informations.',
            ],
            'DEFAULT_GROUP' => [
                'TITLE'       => 'Default Group Not Found',
                'DESCRIPTION' => 'Account registration is not working because the default group {{slug}} does not exist.',
            ],
            'INVALID' => [
                'TITLE'       => 'Account Invalid',
                'DESCRIPTION' => 'Ce compte n\'existe pas. Il a peut-être été supprimé. Veuillez nous contacter pour plus d\'informations.',
            ],
            'NOT_FOUND' => [
                'TITLE'       => 'Account Not Found',
                'DESCRIPTION' => 'This account does not exist. It may have been deleted.',
            ],
            'COMPROMISED' => [
                'TITLE'       => 'Account Compromised',
                'DESCRIPTION' => 'Someone may have used your login information to access this page.  For your safety, all sessions were logged out. Please log in again and check your account for suspicious activity. You may also wish to change your password.',
            ],
            'UNVERIFIED' => [
                'TITLE'       => 'Account Unverified',
                'DESCRIPTION' => 'Votre compte n\'a pas encore été vérifié. Vérifiez vos emails / dossier spam pour les instructions d\'activation du compte.',
            ],
            'EXPIRED' => [
                'TITLE'       => 'Session expired',
                'DESCRIPTION' => 'Votre session a expiré. Veuillez vous connecter à nouveau.',
            ],
            'INVALID_CREDENTIALS' => [
                'TITLE'       => 'Invalid Credentials',
                'DESCRIPTION' => 'User not found or password is invalid.',
            ],
            'LOGGEDIN' => [
                'TITLE'       => 'Already Logged-in',
                'DESCRIPTION' => "Can't access this resource, as you're already logged-in",
            ],
            'LOGIN_REQUIRED' => [
                'TITLE'       => 'Login Required',
                'DESCRIPTION' => 'Please login to continue',
            ],
            'PASSWORD_RESET' => [
                'TITLE'       => 'Invalid Password Reset Token',
                'DESCRIPTION' => 'This password reset request could not be found, or has expired.',
            ],
        ],
        'EMAIL_UPDATED'       => 'Adresse email mise à jour',
        'ERROR'         => [
            '@TRANSLATION'  => 'Error validating account',
            'MISSING_PARAM' => "Account can't be registered as '{{param}}' is required.",
        ],
        
        'HAVE_ONE'            => 'Vous avez déjà un compte ?',
        
        'MASTER_NOT_EXISTS'   => 'Vous ne pouvez pas enregistrer un compte tant que le compte principal n\'a pas été créé!',
        'MY'                  => 'Mon compte',//OK  
        
        'SETTINGS'        => [
            '@TRANSLATION' => 'Paramètres du compte',
            'DESCRIPTION'  => 'Mettez à jour les paramètres de votre compte, y compris votre adresse e-mail, votre nom et votre mot de passe.',
            'EMAIL'        => 'Mise à jour du email',//OK
            'PASSWORD'     => 'Modifier le mot de passe',//OK
            'PERSONAL'     => 'Information personnelle',//OK
            'UPDATED'      => 'Paramètres du compte mis à jour',
        ],

        'TOOLS'        => 'Outils du compte',
        
        'VERIFICATION' => [
            'NEW_LINK_SENT'   => 'Nous avons envoyé un nouveau lien de vérification à {{email}}. Veuillez vérifier vos dossiers de boîte de réception et de spam pour ce courriel.',
            'RESEND'          => 'Renvoyer le courriel de validation',
            'COMPLETE'        => 'Votre compte a été validé. Vous pouvez maintenant vous connecter.',
            'EMAIL'           => 'Veuillez saisir l\'adresse email que vous avez utilisée pour vous inscrire et votre courriel de vérification sera renvoyé.',
            'PAGE'            => 'Renvoyer l\'email de validation de votre nouveau compte.',
            'SEND'            => 'Envoyer le lien de validation de mon compte',
            'TOKEN_NOT_FOUND' => 'Le jeton de vérification n\'existe pas / Le compte est déjà vérifié',
        ],
    ],
    
    'EMAIL' => [
        'INVALID'               => 'Il n\'y a aucun compte pour <strong>{{email}}</strong>.',
        'IN_USE'                => 'Le email <strong>{{email}}</strong> est déjà utilisé.',
        'VERIFICATION_REQUIRED' => 'Email (vérification requise - utiliser une adresse réelle!)',
    ],
    'EMAIL_OR_USERNAME'   => 'Nom d\'utilisateur ou adresse email',
    
    'FIRST_NAME'          => 'Prénom',
    
    'GUEST'               => 'Invité',

    'HEADER_MESSAGE_ROOT' => 'VOUS ÊTES CONNECTÉ EN TANT QUE L\'UTILISATEUR ROOT',
    
    'LAST_NAME'           => 'Nom de famille',
    'LOCALE'              => [
        'ACCOUNT' => 'La langue utilisé pour votre compte d\'utilisateur',
        'INVALID' => '<strong>{{locale}}</strong> n\'est pas une langue valide.',
    ],
    'LOGIN' => [
        '@TRANSLATION'     => 'Connexion',
        'ALREADY_COMPLETE' => 'Vous êtes déjà connecté!',
        'SOCIAL'           => 'Ou se connecter avec',
        'REQUIRED'         => 'Désolé, vous devez être connecté pour accéder à cette ressource.',
    ],
    'LOGOUT'         => 'Déconnexion',
    
    'NAME'           => 'Nom',
    'NAME_AND_EMAIL' => 'Nom et email',
    
    'PASSWORD' => [
        '@TRANSLATION'        => 'Mot de passe',
        'BETWEEN'             => 'Entre {{min}} et {{max}} charactères',
        'CONFIRM'             => 'Confirmer le mot de passe',
        'CONFIRM_CURRENT'     => 'Veuillez confirmer votre mot de passe actuel',
        'CONFIRM_NEW'         => 'Confirmer le nouveau mot de passe',
        'CONFIRM_NEW_EXPLAIN' => 'Confirmer le mot de passe',
        'CREATE'              => [
            '@TRANSLATION' => 'Créer un mot de passe',
            'PAGE'         => 'Choisissez un mot de passe pour votre nouveau compte.',
            'SET'          => 'Définir le mot de passe et se connecter',
        ],
        'CURRENT'         => 'Mot de passe actuel',
        'CURRENT_EXPLAIN' => 'Vous devez confirmer votre mot de passe actuel pour apporter des modifications',
        'FORGOTTEN'       => 'Mot de passe oublié',
        'FORGET'          => [
            '@TRANSLATION'     => 'Mot de passe oublié?',
            'COULD_NOT_UPDATE' => 'Impossible de mettre à jour le mot de passe.',
            'EMAIL'            => 'Veuillez saisir l\'adresse e-mail que vous avez utilisée pour vous inscrire. Un lien avec les instructions pour réinitialiser votre mot de passe vous sera envoyé par email.',
            'EMAIL_SEND'       => 'Envoyer le lien de réinitialisation',
            'INVALID'          => 'Cette requête de réinitialisation de mot de passe n\'a pas pu être trouvée ou a expiré. Veuillez réessayer <a href="{{url}}"> de soumettre votre demande <a>.',
            'PAGE'             => 'Obtenir un lien pour réinitialiser votre mot de passe.',
            'REQUEST_CANNED'   => 'Demande de mot de passe perdu annulée.',
            'REQUEST_SENT'     => 'Si l\'adresse e-mail <strong>{{email}}</strong> correspond à un compte dans notre système, un lien de réinitialisation de mot de passe sera envoyé à <strong>{{email}}</strong>.',
        ],
        'HASH_FAILED'       => 'Le hachage du mot de passe a échoué. Veuillez contacter un administrateur de site.',
        'INVALID'           => 'Le mot de passe actuel ne correspond pas à celui que nous avons au dossier',
        'NEW'               => 'Nouveau mot de passe',
        'NOTHING_TO_UPDATE' => 'Vous ne pouvez pas mettre à jour avec le même mot de passe',
        'RESET'             => [
            '@TRANSLATION' => 'Réinitialiser le mot de passe',
            'CHOOSE'       => 'Veuillez choisir un nouveau mot de passe pour continuer.',
            'CONFIRM'      => 'Êtes-vous sûr de vouloir envoyer à <strong>{{full_name}} ({{user_name}})</strong> un lien qui leur permettra de réinitialiser leur mot de passe ?',
            'PAGE'         => 'Choisissez un nouveau mot de passe pour votre compte.',
            'SEND'         => 'Définir un nouveau mot de passe',
        ],
        'UPDATED' => 'Mot de passe du compte mis à jour',
    ],
    'PROFILE' => [
        'SETTINGS' => 'Paramètres du profil',
        'UPDATED'  => 'Paramètres du profil mis à jour',
    ],
    
    'RATE_LIMIT_EXCEEDED' => 'La limite de tentatives pour cette action a été dépassée. Vous devez attendre {{delay}} secondes avant de pouvoir effectuer une autre tentative.',
    'REGISTER'            => 'S\'inscrire',
    'REGISTER_ME'         => 'Créer mon compte',
    'REGISTRATION'        => [
        'BROKEN'         => 'Nous sommes désolés, il ya un problème avec notre processus d\'enregistrement de compte. Veuillez nous contacter directement pour obtenir de l\'aide.',
        'COMPLETE_TYPE1' => 'Vous êtes inscrit avec succès. Vous pouvez maintenant vous connecter.',
        'COMPLETE_TYPE2' => 'Vous êtes inscrit avec succès. Vous recevrez bientôt un e-mail de validation contenant un lien pour activer votre compte. Vous ne pourrez pas vous connecter avant d\'avoir terminé cette étape.',
        'DISABLED'       => 'Désolé, l\'enregistrement de compte a été désactivé.',
        'LOGOUT'         => 'Désolé, vous ne pouvez pas vous inscrire tout en étant connecté. Veuillez vous déconnecter en premier.',
        'QUESTION'       => "Pas encore de compte?",//OK
        'WELCOME'        => 'L\'inscription est rapide et simple.',
    ],
    'REMEMBER_ME'             => 'Se souvenir de moi!',
    'REMEMBER_ME_ON_COMPUTER' => 'Se souvenir de moi sur cet ordinateur (non recommandé pour les ordinateurs publics)',
    
    'SIGNIN'                  => 'Se connecter',
    'SIGNIN_OR_REGISTER'      => 'Se connecter ou s\'inscrire',
    'SIGNUP'                  => 'S\'inscrire',
    
    'TOS'                     => 'Termes et conditions',
    'TOS_AGREEMENT'           => 'En créant un compte avec {{site_title}}, vous acceptez les <a {{link_attributes | raw}}>termes et conditions</a>.',
    'TOS_FOR'                 => 'Termes et conditions pour {{title}}',
    
    'USERNAME'                => [
        '@TRANSLATION'  => 'Nom d\'utilisateur',
        'CHOOSE'        => 'Choisissez un nom d\'utilisateur unique',
        'INVALID'       => 'Nom d\'utilisateur invalide',
        'IN_USE'        => 'Le nom d\'utilisateur \'{{username}}\' est déjà utilisé.',
        'NOT_AVAILABLE' => 'Le nom d\'utilisateur <strong>{{user_name}}</strong> n\'est pas disponible. Choisissez un autre nom, ou cliquez sur « suggérer ».',
    ],
    'USER_ID_INVALID'       => 'L\'identifiant d\'utilisateur demandé n\'existe pas.',
    'USER_OR_EMAIL_INVALID' => 'Nom d\'utilisateur ou adresse e-mail non valide.',
    'USER_OR_PASS_INVALID'  => 'Nom d\'utilisateur ou mot de passe incorrect.',
    
    'WELCOME'               => 'Bienvenue {{full_name}}!',
];
