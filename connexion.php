<?php
// Lecture des identifiants à partir de connexion.ini.
$tableau_ini = parse_ini_file("connexion.ini");

// Connexion à MySQL et sélection de la base de données.
$bdd = new PDO($tableau_ini['dsn'], $tableau_ini['utilisateur'], $tableau_ini['mot de passe']);
$bdd -> query("SET NAMES utf8"); // Le script PHP communique avec la base de données en utf-8.
$bdd -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // En cas d’erreur, une exception doit être levée.
?>
