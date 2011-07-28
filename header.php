<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

// Chargement des fonctions.
include_once("/Users/fl4t/Sites/AuMarcheCouvert/traitement/fonctions.php");
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Au marché couvert</title>
      <!-- description et auteur -->
      <meta name="description" content="Gestion des restaurants de l'entreprise Au marché couvert.">
      <meta name="author" content="Julien Stechele">
      <!-- Renvoi vers un fichier séparé style.css -->
      <link href="http://localhost/bdd/style.css" type="text/css" rel="stylesheet" media="screen">
   </head>
   <body>
<?php
// Appel de la fonction ConnexionBDD
$objBDD = F_ConnexionBDD();
?>
      <div id="cadre">
         <header>
         <!-- Placement de l'image "degrade-haut.php" via le css -->
         </header>
         <div id="titre">
            <h1>Au marché couvert</h1>
         </div>
         <nav>
            <ul id="onglet">
