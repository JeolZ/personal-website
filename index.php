<?php
require_once 'myPDO.include.php';
require_once 'autoload.inc.php';

// Cr�ation d'une page web avec le titre
$webpage = new WebPage("Welcome to Joel ZHU's personal website");

// Ajout du contenu
$webpage->appendContent("Hello world");

// Test connectivit� � la BD
$PDO = myPDO::getInstance()->prepare("SELECT *
    FROM USER");
$PDO->execute();
$user = $PDO->fetch();
var_dump($user);

// Affichage de la page
echo $webpage->toHTML();