<?php

// Cr�e par : Jo�l ZHU
// Date : 26/01/2018

// Fichier qui permet de connecter un utilisateur

require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

$user = User::getUser($_POST['pseudo'], $_POST['password']);
var_dump($user);

/*
// Cr�ation d'une page web avec le titre
$webpage = new WebPage("Utilisateur connect�");

// Ajout du contenu
$webpage->appendContent("Connect� !");

// Affichage de la page
echo $webpage->toHTML();
*/