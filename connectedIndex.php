<?php

// Cr�e par : Jo�l ZHU
// Date : 26/01/2018

// Page d'accueil d'un utilisateur connect�

require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

// Cr�ation d'une page web avec le titre
$webpage = new WebPage("Utilisateur connect�");

// Ajout du contenu
$webpage->appendContent("Connect� !");


// Affichage de la page
echo $webpage->toHTML();