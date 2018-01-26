<?php

// Crée par : Joël ZHU
// Date : 26/01/2018

// Page d'accueil d'un utilisateur connecté

require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

// Création d'une page web avec le titre
$webpage = new WebPage("Utilisateur connecté");

// Ajout du contenu
$webpage->appendContent("Connecté !");


// Affichage de la page
echo $webpage->toHTML();