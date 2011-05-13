<?php
//////////////////////////////////////////////
//                                          //
//                fonctions                 //
//                                          //
//////////////////////////////////////////////

//
// On se connecte sur la base de donnée en passant par un essai
//
function F_ConnexionBDD()
{
   try
   {
      $objBDD = new PDO('mysql:host=localhost;dbname=AuMarcheCouvert;', 'root', 'root');
      return $objBDD;
   }
   catch(Exception $e)
   {
      die('Erreur F_ConnexionBDD : ' . $e->getMessage());
   }
}

//
// On affecte toutes les valeurs de la superglobale $_POST à $_SESSION si ils sont valide. 
// 
function P_TransfertPostDansSession()
{
   // On detruit la session pour effacer les valeurs précédentes éventuelles. 
   session_destroy();
   // Si le restaurant a été renseigné, on continue.
   if ($_POST['listeRestaurant'] != "Vide")
   {
      $_SESSION['NomRestaurant'] = stripslashes($_POST['listeRestaurant']);
      // On crée un compteur pour ajouter à la suite du tableau.
      $intCompteurAjout = 0;
      for($NombreDeProduits=1;$NombreDeProduits<=5;$NombreDeProduits++)
      {
         // Si un produit a été séléctionné.
         if ($_POST['listeProduits' . $NombreDeProduits] != "Vide")
         {
            // Si la quantité et le prix ne sont pas vide et ne sont pas égal à zero 
            // ("", NULL, 0 est interpreté comme vide pour empty, voila pourquoi je teste pas la valeur 0)
            if (!empty($_POST['QuantiteProduit' . $NombreDeProduits]) && !empty($_POST['PrixDuJour' . $NombreDeProduits]))
            {
               $intCompteurAjout += 1;
               $_SESSION['Panier']['DesignProduit'][$intCompteurAjout] = $_POST['listeProduits' . $NombreDeProduits];
               // On force tout ce qui a pu être tapé en réel, si c'était autre chose qu'un entier, ça vaudra 0.0 
               $_SESSION['Panier']['QuantiteProduit'][$intCompteurAjout] = (float) preg_replace('#,#','.',$_POST['QuantiteProduit' . $NombreDeProduits]);
               // J'utilise une expréssion régulière au cas ou une virgule est utilisé, les décimaux php n'accepte que le point.
               $_SESSION['Panier']['PrixDuJour'][$intCompteurAjout] = (float) preg_replace('#,#','.',$_POST['PrixDuJour' . $NombreDeProduits]);
            }
         }
      }
   }
   $_SESSION['NombreDeProduits'] = count($_SESSION['Panier']['DesignProduit']);
   // affichage pour savoir si c'est fait.
   echo '<pre>';
   echo 'SESSION : <br />';
   print_r($_SESSION);
   echo '</pre>';
}

//
// Recupère le code du restaurant a partir du nom du restaurant fourni en paramètre.
// 
function F_CodeDuRestaurant($strNomRestaurant)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   try
   {
      // On recupère le code du restaurant qui passe commande.
      $objCodeRestaurant = $objBDD->prepare('SELECT CodeRestaurant FROM Restaurants WHERE NomRestaurant=:NomRestaurant');
      $objCodeRestaurant->execute(array('NomRestaurant' => $strNomRestaurant));
      $strCodeRestaurant = $objCodeRestaurant->fetch();
      $objCodeRestaurant->closeCursor(); // Termine le traitement de la requête
      return $strCodeRestaurant['CodeRestaurant']; // On retourne la valeur du champ CodeRestaurant
   }
   catch(Exception $e)
   {
      die('Erreur F_CodeDuRestaurant : ' . $e->getMessage());
   }
}

//
// Création de nouvelle commande
//
function P_CreationCommande($intCodeRestaurant)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // On ajoute une entrée dans la table commande.
      // Pas utile de préparer ici car intCodeRestaurant provient de la base de donnée qui a générer le code tout seul.
      $objBDD->exec('INSERT INTO Commandes(NumCommande, CodeRestaurant, DateCommande) VALUES(\'\','.$intCodeRestaurant.',NOW())');
   }
   catch(Exception $e)
   {
      die('Erreur P_CreationCommande : ' . $e->getMessage());
   }
}

//
// Connaitre la référence d'un produit via son nom
//
function F_RefDuProduit($strNomProduit)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // On va chercher la référence du produits
      $objRefProduit = $objBDD->prepare('SELECT RefProduit FROM Produits WHERE DesignProduit=:DesignProduit');
      $objRefProduit->execute(array('DesignProduit' => $strNomProduit));
      $intRefProduit = $objRefProduit->fetch();
      $objRefProduit->closeCursor();
      return $intRefProduit['RefProduit'];
   }
   catch(Exception $e)
   {
      die('Erreur F_RefDuProduit : ' . $e->getMessage());
   }
}

//
// Ajout des lignes dans Contenir correspondant a une commande.
//
function P_AjoutDesProduits($RefProduit,$intDerniereID,$QteCommande,$PrixDuJour)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les insertions à l'aide d'une requête préparée.
      $objPreparation = $objBDD->prepare('INSERT INTO Contenir VALUES(:RefProduit, :NumCommande, :QteCommande, :PrixDuJour)');
      $objPreparation->execute(array(
      'RefProduit' => $RefProduit, 
      'NumCommande' => $intDerniereID,
      'QteCommande' => $QteCommande,
      'PrixDuJour' => $PrixDuJour));
   }
   catch(Exception $e)
   {
      die('Erreur P_AjoutDesProduits : ' . $e->getMessage());
   }
}

//
// Fonction d'ajout d'un nouveau restaurant
// 
function P_AjoutRestaurant($NomRestaurant,$Adr1Restaurant,$Adr2Restaurant,$CpRestaurant,$VilleRestaurant,$MelRestaurant,$TelRestaurant)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les insertions à l'aide d'une requête préparée.
      $objPreparation = $objBDD->prepare('INSERT INTO Restaurants VALUES(\'\',:NomRestaurant,:Adr1Restaurant,:Adr2Restaurant,:CpRestaurant,:VilleRestaurant,:MelRestaurant,:TelRestaurant)');
      $objPreparation->execute(array(
      'NomRestaurant' => $NomRestaurant,
      'Adr1Restaurant' => $Adr1Restaurant,
      'Adr2Restaurant' => $Adr2Restaurant,
      'CpRestaurant' => $CpRestaurant,
      'VilleRestaurant' => $VilleRestaurant,
      'MelRestaurant' => $MelRestaurant,
      'TelRestaurant' => $TelRestaurant));
   }
   catch(Exception $e)
   {
      die('Erreur P_AjoutRestaurant : ' . $e->getMessage());
   }
}

//
// Ajout de nouveau produit
//
function P_AjoutProduit($DesignProduit,$PrixProduit,$UniteVente)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les insertions à l'aide d'une requête préparée.
      $objPreparation = $objBDD->prepare('INSERT INTO Produits VALUES(\'\',:DesignProduit,:PrixProduit,:UniteVente)');
      $objPreparation->execute(array(
      'DesignProduit' => $DesignProduit,
      'PrixProduit' => $PrixProduit,
      'UniteVente' => $UniteVente));
   }
   catch(Exception $e)
   {
      die('Erreur P_AjoutProduit : ' . $e->getMessage());
   }
}

//
// Donne les informations d'un restaurant graçe a son nom
// Utiliser dans la modification d'un restaurant
//
function F_ValeurDuRestaurant($strNomRestaurant)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les mise à jours à l'aide d'une requête préparée.
      $objValeurDuRestaurant = $objBDD->prepare('SELECT * FROM Restaurants WHERE NomRestaurant=:NomRestaurant');
      $objValeurDuRestaurant->execute(array('NomRestaurant' => $strNomRestaurant));
      $strValeurDuRestaurant = $objValeurDuRestaurant->fetch();
      $objValeurDuRestaurant->closeCursor(); // Termine le traitement de la requête
      return $strValeurDuRestaurant; // On retourne strValeurDuRestaurant
   }
   catch(Exception $e)
   {
      die('Erreur F_ValeurDuRestaurant : ' . $e->getMessage());
   }
}

//
// Donne les informations d'un produit graçe a son nom
// Utiliser dans la modification d'un produit 
//
function F_ValeurDuProduit($strNomProduit)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les mise à jours à l'aide d'une requête préparée.
      $objValeurDuProduit = $objBDD->prepare('SELECT * FROM Produits WHERE DesignProduit=:NomProduit');
      $objValeurDuProduit->execute(array('NomProduit' => $strNomProduit));
      $strValeurDuProduit = $objValeurDuProduit->fetch();
      $objValeurDuProduit->closeCursor(); // Termine le traitement de la requête
      return $strValeurDuProduit; // On retourne strValeurDuProduit
   }
   catch(Exception $e)
   {
      die('Erreur F_ValeurDuProduit : ' . $e->getMessage());
   }
}

//
// Mise à jour du restaurant actuellement modifié
//
function P_MAJRestaurant($SauvegardeNomRestaurant,$NomRestaurant,$Adr1Restaurant,$Adr2Restaurant,$CpRestaurant,$VilleRestaurant,$MelRestaurant,$TelRestaurant)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les insertions à l'aide d'une requête préparée.
      $objPreparation = $objBDD->prepare('UPDATE Restaurants SET NomRestaurant=:NomRestaurant, Adr1Restaurant=:Adr1Restaurant, Adr2Restaurant=:Adr2Restaurant, CpRestaurant=:CpRestaurant, VilleRestaurant=:VilleRestaurant, MelRestaurant=:MelRestaurant, TelRestaurant=:TelRestaurant WHERE NomRestaurant="'.$SauvegardeNomRestaurant.'"');
      $objPreparation->execute(array(
      'NomRestaurant' => $NomRestaurant,
      'Adr1Restaurant' => $Adr1Restaurant,
      'Adr2Restaurant' => $Adr2Restaurant,
      'CpRestaurant' => $CpRestaurant,
      'VilleRestaurant' => $VilleRestaurant,
      'MelRestaurant' => $MelRestaurant,
      'TelRestaurant' => $TelRestaurant));
   }
   catch(Exception $e)
   {
      die('Erreur P_MAJRestaurant : ' . $e->getMessage());
   }
}

//
// Mise à jour du produit actuellement modifié
//
function P_MAJProduit($SauvegardeNomProduits,$DesignProduit,$PrixProduit,$UniteVente)
{
   try
   { 
      global $objBDD; // On travaille sur la variable globale $objBDD.
      // Je fais les insertions à l'aide d'une requête préparée.
      $objPreparation = $objBDD->prepare('UPDATE Produits SET DesignProduit=:DesignProduit, PrixProduit=:PrixProduit, UniteVente=:UniteVente WHERE DesignProduit=:SauvegardeNomProduits');
      $objPreparation->execute(array(
      'DesignProduit' => $DesignProduit,
      'PrixProduit' => $PrixProduit,
      'SauvegardeNomProduits' => $SauvegardeNomProduits,
      'UniteVente' => $UniteVente));
   }
   catch(Exception $e)
   {
      die('Erreur P_MAJProduit : ' . $e->getMessage());
   }
}

//
// Suppression pur et simple du restaurant graçe à son nom
//
function P_SuppressionRestaurant($NomRestaurant)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      $objPreparation = $objBDD->prepare('DELETE FROM Restaurants WHERE NomRestaurant=:NomRestaurant');
      $objPreparation->execute(array(
      'NomRestaurant' => $NomRestaurant));
   }
   catch(Exception $e)
   {
      die('Erreur P_SuppressionRestaurant : ' . $e->getMessage());
   }
}

//
// Suppression pur et simple du Produit graçe à son nom
//
function P_SuppressionProduit($DesignProduit)
{
   try
   {
      global $objBDD; // On travaille sur la variable globale $objBDD.
      $objSuppressionProduit = $objBDD->prepare('DELETE FROM Produits WHERE DesignProduit=:DesignProduit');
      $objSuppressionProduit->execute(array('DesignProduit' => $DesignProduit));
   }
   catch(Exception $e)
   {
      die('Erreur P_SuppressionProduit : ' . $e->getMessage());
   }
}
?>
