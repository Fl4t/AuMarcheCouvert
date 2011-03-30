<?php
   // On démarre la session AVANT d'écrire du code HTML
   session_start();
   //session_destroy();

   // Chargement des fonctions.
   include("fonctions.php");

   // Subdivision du panier
   $_SESSION['NomRestaurant'] = string;
   $_SESSION['Panier']['DesignProduit'] = array();
   $_SESSION['Panier']['QuantiteProduit'] = array();
   $_SESSION['Panier']['PrixProduit'] = array();
?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Au marché couvert</title>
      <!-- meta -->
      <meta name="description" content="Gestion des restaurants de l'entreprise Au marché couvert.">
      <meta name="author" content="Julien Stechele">
      <!-- mon icon -->
      <link rel="shortcut-icon" href="favicon.ico">
      <!-- Renvoi vers un fichier séparé style.css -->
      <link href="style.css" type="text/css" rel="stylesheet" media="screen">
   </head>
   <body>
      <?php 
         // Appel de la fonction de type procédure ConnexionBDD
         $objBDD = ConnexionBDD();
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
