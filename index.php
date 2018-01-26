<?php

require_once 'autoload.inc.php';

// Création d'une page web avec le titre
$webpage = new WebPage("Welcome to Joel ZHU's personal website");

// Ajout du contenu
$webpage->appendContent("Hello world");

// Affichage de la page
echo $webpage->toHTML();