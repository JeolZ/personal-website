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
     * R�cup�re le pseudo
     * 
     * @return string Le pseudo
     */
    public function pseudo()
    {
        return $this->pseudo;
    }

    /**
     * Cr�er un formulaire de connexion en HTML
     * 
     * @param string $action
     *            POST OU GET
     * @param string $submitText
     *            Texte sur le bouton de validation
     * @return string Le formulaire en HTML
     */
    public static function loginForm($action, $submitText = 'OK')
    {
        $html = "";
        
        $html .= "<form method=post action=" . $action . ">";
        $html .= "<input type=text name=pseudo placeholder=pseudo>";
        $html .= "<input type=password name=password>";
        $html .= "<button type=submit>" . $submitText . "</button>";
        $html .= "</form>";
        
        return $html;
    }

    /**
     * Cr�er un formulaire de d�connexion en HTML
     * 
     * @param string $action
     *            POST OU GET
     * @param string $submitText
     *            Texte sur le bouton de validation
     * @return string Le formulaire en HTML
     */
    public static function logoutForm($action, $submitText = 'Se deconnecter')
    {
        $html = "";
        
        $html .= "<form method=post action=" . $action . ">";
        $html .= "<button id='logout' name='logout' type=submit>" . $submitText . "</button>";
        $html .= "</form>";
        
        User::logoutIfRequested();
        return $html;
    }

    // $data est un array
    // en cas de succ�s, retourne un User
    // en cas d'�chec, une AuthenticationException est lanc�e
    
    // TODO: comeback to this
    /**
     * Connecte un utilisateur
     * 
     * @param array $data
     *            Donn�es de connexion (pseudo et password)
     * @throws AuthenticationException
     * @return unknown
     */
    public static function createFromAuthSHA1($data)
    {
        User::startSession();
        $PDO = myPDO::getInstance()->prepare("SELECT *
          FROM user
          WHERE SHA1(concat(SHA1(login), ?, sha1pass)) = ?");
        
        $PDO->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        $PDO->execute(array(
            $_SESSION[self::SESSION_KEY]['challenge'],
            $_GET['code']
        ));
        $user = $PDO->fetch();
        if ($user == false) {
            throw new Exception('User n\'a pas �t� trouv�');
        }
        
        $_SESSION[self::SESSION_KEY]['connected'] = true;
        return $user;
    }

    /**
     * Indique si un utilisateur est connect� ou non
     * 
     * @return bool true si connect�, false sinon
     */
    public static function isConnected()
    {
        User::startSession();
        if (isset($_SESSION[self::SESSION_KEY]['connected'])) {
            return $_SESSION[self::SESSION_KEY]['connected'];
        }
    }

    /**
     * D�connecte l'utilisateur
     */
    public static function logoutIfRequested()
    {
        User::startSession();
        if (isset($_POST['logout'])) {
            unset($_SESSION[self::SESSION_KEY]);
            session_destroy();
        }
    }

    /**
     * M�morise l'utilisateur dans la session
     */
    public function saveIntoSession()
    {
        User::startSession();
        $_SESSION[self::SESSION_KEY]['user'] = $this;
    }

    /**
     * Lecture de l'objet User dans la session
     * @throws Exception si l'objet n'est pas dans la session
     * @return User
     */
    public static function createFromSession()
    {
        User::startSession();
        if (isset($_SESSION[self::SESSION_KEY]['user'])) {
            if ($_SESSION[self::SESSION_KEY]['user'] instanceof User) {
                return $_SESSION[self::SESSION_KEY]['user'];
            }
        } else {
            throw new Exception("Session ne contient pas d'user !");
        }
    }
    
    /**
     * G�n�re un code al�atoire de longueur $size compos� � partir des caract�res [a-z], [A-Z] et [1-9]
     * @param int $size Taille du code
     * @return string Le code g�n�r�
     */
    public static function randomString($size)
    {
        $minMajChiff = rand(0, 2);
        $code = "";
        for ($i = 0; $i < $size; $i ++) {
            $minMajChiff = rand(0, 2);
            if ($minMajChiff == 0) {
                $code .= chr(rand(65, 90));
            } else if ($minMajChiff == 1) {
                $code .= chr(rand(97, 122));
            } else if ($minMajChiff == 2) {
                $code .= chr(rand(48, 57));
            }
        }
        return $code;
    }
    
    /**
     * Validation de la connexion de l'Utilisateur
     * @param array $data tableau contenant la cl� 'code' associ�e au condensat du login et au mot de passe
     *
     * @return User utilisateur authentifi�
     */
    public static function loginFormSHA1($action, $submitText = 'OK')
    {
        $challenge = User::randomString(9);
        $_SESSION[self::SESSION_KEY]['challenge'] = $challenge;
        
        $html = <<<HTML
		<script type='text/javascript' src='sha1.js'></script>
		<form onsubmit='return donnerCode(this, "{$challenge}")' method=GET action={$action}>
		<input type=text name=login placeholder=login>
		<input type=password name=pass>
		<input id='code' type=hidden name=code>
		<button type=submit> {$submitText} </button>
		</form>
HTML;
        return $html;
    }
}