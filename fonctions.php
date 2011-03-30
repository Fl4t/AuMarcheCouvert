<?php
//////////////////////////////////////////////
//                                          //
//               constantes                 //
//                                          //
//////////////////////////////////////////////

// Constante TVA
define('intTVA',1.055);

//////////////////////////////////////////////
//                                          //
//                fonctions                 //
//                                          //
//////////////////////////////////////////////

// Fonction ConnexionBDD
// On se connecte sur la base de donnée en passant par un essai
// affiche une erreur explicite.
function ConnexionBDD()
{
   try
   {
      $objBDD = new PDO('mysql:host=localhost;dbname=AuMarcheCouvert;', 'root', 'root');
      return $objBDD;
   }
   catch(Exception $e)
   {
      die('Erreur : ' . $e->getMessage());
   }
}

// Fonction TransfertPostSession
// On affecte toutes les valeurs de la superglobale $_POST à $_SESSION si ils sont valide. 
function TransfertPostDansSession()
{
   // Si le restaurant a été renseigné, on continue.
   if ($_POST['listeRestaurant'] != "Vide")
   {
      $_SESSION['NomRestaurant'] = $_POST['listeRestaurant'];
      // On crée un compteur pour ajouter à la suite du tableau.
      $intCompteurAjout = 0;
      for($NombreDeProduits=1;$NombreDeProduits<=5;$NombreDeProduits++)
      {
         // Si le produit a été séléctionné et qu'une quantité a été tapé et qu'elle est supérieur à 1.
         if ($_POST['listeProduits' . $NombreDeProduits] != "Vide")
         {
            if ($_POST['QuantiteProduit' . $NombreDeProduits] != 0)
            {
               // On incrémente le compteur quand les conditions sont vraies.
               $intCompteurAjout += 1;
               // On remplie le tableau 'DesignProduit' qui ce trouve lui même dans le tabeau à l'index 0 de 'Panier'
               $_SESSION['Panier']['DesignProduit'][$intCompteurAjout] = $_POST['listeProduits' . $NombreDeProduits];
               // On remplie le tableau 'QuantiteProduit' qui ce trouve lui même dans le tabeau à l'index 1 de 'Panier'
               // On force tout ce qui a pu être tapé en entier, si c'était autre chose qu'un entier, ça vaudra 0 
               $_SESSION['Panier']['QuantiteProduit'][$intCompteurAjout] = (integer) ($_POST['QuantiteProduit' . $NombreDeProduits]);
               // On ajoute le prix du produit via la fonction PrixDuProduit.
               $_SESSION['Panier']['PrixProduit'][$intCompteurAjout] = PrixDuProduit($_SESSION['Panier']['DesignProduit'][$intCompteurAjout]);
            }
         }
      }
   }
   // affichage pour savoir si c'est fait.
   //echo '<pre>';
   //echo 'SESSION : <br />';
   //print_r($_SESSION);
   //echo '</pre>';
}

function PrixDuProduit($NomProduit)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   // On va chercher le prix du produits contenu en paramètre
   $objPrixProduits = $objBDD->query('SELECT PrixProduit FROM Produits WHERE DesignProduit = \''.$NomProduit.'\'') or die(print_r($objBDD->errorInfo()));
   $PrixProduit = $objPrixProduits->fetch();
   $objPrixProduits->closeCursor();
   return $PrixProduit['PrixProduit']; // On retourne la valeur du champ PrixProduit
}
?>
