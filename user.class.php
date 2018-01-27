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

    /**
     * Cr�er un formulaire d'inscription en HTML
     * 
     * @param string $action
     *            Lien du fichier .php sur lequel rediriger que le formulaire est soumis
     * @param string $submitText
     *            Le texte dans le bouton de validation
     * @return string Le formulaire en HTML
     */
    public static function loginForm($action, $submitText = 'OK')
    {
        // encapsule le formulaire dans un bloc <div>
        $html = "<div>";
        
        $html .= "<form method=post action=" . $action . ">";
        $html .= "<input type=text name=pseudo placeholder=pseudo>";
        $html .= "<input type=password name=password placeholder=password>";
        $html .= "<button type=submit>" . $submitText . "</button>";
        $html .= "</form> </div>";
        
        return $html;
    }

    /**
     * R�cup�re un utilisateur dans la BD en fonction de son pseudo et de son password
     * 
     * @param string $pseudo
     *            Pseudo de l'utilisateur
     * @param string $password
     *            Mot de passe de l'utilisateur
     * @return User L'utilisateur
     */
    public static function getUser($pseudo, $password)
    {
        // requ�te pour avoir l'utilisateur avec la combinaison pseudo/mdp
        $PDO = myPDO::getInstance()->prepare("
            SELECT idUser, pseudo, isAdmin
            FROM USER 
            WHERE pseudo = ? 
            AND password = ?
        ");
        
        // pour qu'on puisse stocker le r�sultat dans un objet User
        $PDO->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        // on ex�cute la requ�te
        $PDO->execute(array(
            $pseudo,
            $password
        ));
        // on stocke le r�sultat dans un objet User
        $user = $PDO->fetch();
        
        // si l'utilisateur n'a pas �t� trouv�
        if(!$user){
            // on lance une exception
            throw new Exception('User n\'a pas �t� trouv� !');
        }
        
        return $user;
    }
}