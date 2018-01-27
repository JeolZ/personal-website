<?php

// Crée par : Joël ZHU
// Date : 26/01/2018

// Fichier qui permet de connecter un utilisateur

require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

$user = User::getUser($_POST['pseudo'], $_POST['password']);
var_dump($user);

/*
// Création d'une page web avec le titre
$webpage = new WebPage("Utilisateur connecté");

// Ajout du contenu
$webpage->appendContent("Connecté !");

// Affichage de la page
echo $webpage->toHTML();
*/