<?php

// Crée par : Joël ZHU
// Date : 26/01/2018

final class myPDO {
    /**
     * @var myPDO $_PDOInstance Instance unique.
     */
    private static $_PDOInstance   = null ;
    
    /**
     * @var string $_DSN DSN pour la connexion BD.
     */
    private static $_DSN           = null ;
    /**
     * @var string $_username Nom d'utilisateur pour la connexion BD.
     */
    private static $_username      = null ;
    /**
     * @var string $_password Mot de passe pour la connexion BD.
     */
    private static $_password      = null ;
    /**
     * @var array $_driverOptions Options du pilote BD.
     */
    private static $_driverOptions = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ) ;
    
    /**
     * Constructeur privé.
     */
    private function __construct() {
        /*
         * Pour vous empêcher de construire
         * des instances de myPDO qui sont inutiles
         */
    }
    
    /**
     * Point d'accès à l'instance unique.
     * L'instance est créée au premier appel et réutilisée aux appels suivants.
     * @throws Exception si la configuration n'a pas été effectuée.
     *
     * @return myPDO instance unique
     */
    public static function getInstance() {
        if (is_null(self::$_PDOInstance)) {
            if (self::hasConfiguration()) {
                self::$_PDOInstance = new PDO(self::$_DSN, self::$_username, self::$_password, self::$_driverOptions) ;
            }
            else {
                throw new Exception(__CLASS__ . ": Configuration not set") ;
            }
        }
        return self::$_PDOInstance ;
    }
    
    /**
     * Fixer la configuration de la connexion à la BD.
     *
     * @param string $dsn DNS pour la connexion BD.
     * @param string $username Utilisateur pour la connexion BD.
     * @param string $password Mot de passe pour la connexion BD.
     * @param array $driver_options Options du pilote BD.
     *
     * @return void
     */
    public static function setConfiguration($dsn, $username='', $password='', array $driver_options=array()) {
        self::$_DSN           = $dsn ;
        self::$_username      = $username ;
        self::$_password      = $password ;
        self::$_driverOptions = $driver_options + self::$_driverOptions ;
    }
    
    /**
     * Vérifier si la configuration de la connexion à la BD a été effectuée.
     *
     * @return bool
     */
    private static function hasConfiguration() {
        return self::$_DSN !== null ;
    }
}


/*
 // Exemple de configuration et d'utilisation
 
 myPDO::setConfiguration('mysql:host=mysql;dbname=cutron01_cdobj;charset=utf8', 'web', 'web') ;
 
 $stmt = myPDO::getInstance()->prepare(<<<SQL
 SELECT *
 FROM artiste
 ORDER BY name
 SQL
 ) ;
 
 $stmt->execute() ;
 
 while (($ligne = $stmt->fetch()) !== false) {
 echo "<p>{$ligne['name']}\n" ;
 }
 */
