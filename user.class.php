<?php

// Cr�e par : Jo�l ZHU
// Date : 26/01/2018
require_once 'myPDO.include.php';

// Classe qui g�re les utilisateurs
class User
{

    // Identifiant dans la BD
    protected $idUser = null;

    // Pseudo
    protected $pseudo = null;

    // Indique si l'utilisateur est un administrateur ou non
    protected $isAdmin = null;

    // Session de l'utilisateur connect�
    const SESSION_KEY = '__user__';

    /**
     * D�bute la session
     */
    private static function startSession()
    {
        switch (session_status()) {
            case PHP_SESSION_DISABLED:
                throw new Exception('Session disabled');
                break;
            case PHP_SESSION_ACTIVE:
                break;
            case PHP_SESSION_NONE:
                if (headers_sent($file, $line)) {
                    throw new Exception($file . $line . 'headers d�j� envoy�s fichier {$file}, ligne {$line}');
                }
                session_start();
                break;
        }
    }

    /**
     * Constructeur priv�
     */
    private function __construct()
    {}
}