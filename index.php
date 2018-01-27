<?php

// Crée par : Joël ZHU
// Date : 26/01/2018

// Page d'accueil
require_once 'myPDO.include.php';
require_once 'webpage.class.php';
require_once 'user.class.php';

/**
 * Création d'une page web avec le titre
 */ 
$webpage = new WebPage("Welcome to Joel ZHU's personal website");

/**
 * Ajout du formulaire de connexion
 */ 
// Formulaire qui renvoie vers un script php qui permet d'effectuer la connexion
$loginForm = User::loginForm('connecter.php');
$webpage->appendContent($loginForm);

/**
 * Affichage de la page
 */
echo $webpage->toHTML();