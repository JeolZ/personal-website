<?php

// Crée par : Joël ZHU
// Date : 26/01/2018

require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

// Création d'une page web avec le titre
$webpage = new WebPage("Welcome to Joel ZHU's personal website");

// Ajout du contenu
$webpage->appendContent("Hello world");



// Affichage de la page
echo $webpage->toHTML();