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
function F_ConnexionBDD()
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
function P_TransfertPostDansSession()
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
            if (empty($_POST['QuantiteProduit'.$NombreDeProduits]) || empty($_POST['PrixDuJour'.$NombreDeProduits]))
            {
            }
            else
            {
               // On incrémente le compteur quand les conditions sont vraies.
               $intCompteurAjout += 1;
               // On remplie le tableau 'DesignProduit' qui ce trouve lui même dans le tabeau à l'index 0 de 'Panier'
               $_SESSION['Panier']['DesignProduit'][$intCompteurAjout] = $_POST['listeProduits' . $NombreDeProduits];
               // On remplie le tableau 'QuantiteProduit' qui ce trouve lui même dans le tabeau à l'index 1 de 'Panier'
               // On force tout ce qui a pu être tapé en entier, si c'était autre chose qu'un entier, ça vaudra 0 
               $_SESSION['Panier']['QuantiteProduit'][$intCompteurAjout] = (integer) $_POST['QuantiteProduit' . $NombreDeProduits];
               // On ajoute le prix du produit via la fonction PrixDuProduit.
               // J'utilise une expréssion régulière au cas ou une virgule est utilisé, les décimaux php n'accepte que le point.
               $_SESSION['Panier']['PrixDuJour'][$intCompteurAjout] = preg_replace('#,#','.',$_POST['PrixDuJour'.$NombreDeProduits]);
            }
         }
      }
   }
   $_SESSION['NombreDeProduits'] = count($_SESSION['Panier']['DesignProduit']);
   // affichage pour savoir si c'est fait.
   //echo '<pre>';
   //echo 'SESSION : <br />';
   //print_r($_SESSION);
   //echo '</pre>';
}
function F_CodeDuRestaurant($strNomRestaurant)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   // On recupère le code du restaurant qui passe commande.
   $objCodeRestaurant = $objBDD->query('SELECT CodeRestaurant FROM Restaurants WHERE NomRestaurant = \''.$strNomRestaurant.'\'') or die(print_r($objBDD->errorInfo()));
   $strCodeRestaurant = $objCodeRestaurant->fetch();
   $objCodeRestaurant->closeCursor(); // Termine le traitement de la requête
   return $strCodeRestaurant['CodeRestaurant']; // On retourne la valeur du champ CodeRestaurant
}

function F_RefDuProduit($strNomProduit)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   // On va chercher la référence du produits
   $objRefProduit = $objBDD->query('SELECT RefProduit FROM Produits WHERE DesignProduit = \''.$strNomProduit.'\'') or die(print_r($objBDD->errorInfo()));
   $intRefProduit = $objRefProduit->fetch();
   $objRefProduit->closeCursor();
   return $intRefProduit['RefProduit'];
}

function P_AjoutRestaurant($NomRestaurant,$Adr1Restaurant,$Adr2Restaurant,$CpRestaurant,$VilleRestaurant,$MelRestaurant,$TelRestaurant)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   // Je fais les insertions à l'aide d'une requête préparée.
   $objPreparation = $objBDD->prepare('INSERT INTO Restaurants VALUES(\'\',:NomRestaurant,:Adr1Restaurant,:Adr2Restaurant,:CpRestaurant,:VilleRestaurant,:MelRestaurant,:TelRestaurant)');
   $objPreparation->execute(array(
      'NomRestaurant' =>$NomRestaurant,
      'Adr1Restaurant' =>$Adr1Restaurant,
      'Adr2Restaurant' =>$Adr2Restaurant,
      'CpRestaurant' =>$CpRestaurant,
      'VilleRestaurant' =>$VilleRestaurant,
      'MelRestaurant' =>$MelRestaurant,
      'TelRestaurant' =>$TelRestaurant));
}

function P_AjoutProduit($DesignProduit,$PrixProduit,$UniteVente)
{
   global $objBDD; // On travaille sur la variable globale $objBDD.
   // Je fais les insertions à l'aide d'une requête préparée.
   $objPreparation = $objBDD->prepare('INSERT INTO Produits VALUES(\'\',:DesignProduit,:PrixProduit,:UniteVente)');
   $objPreparation->execute(array(
   'DesignProduit' =>$DesignProduit,
   'PrixProduit' =>$PrixProduit,
   'UniteVente' =>$UniteVente));
}
//function LectureBDD($strRequete)
//{
   //global $objBDD; // On travaille sur la variable globale $objBDD.
   //// On va chercher le prix du produits contenu en paramètre
   //$objValeurRecolter = $objBDD->query($strRequete) or die(print_r($objBDD->errorInfo()));
   //$tableauValeurRecolter = $objPrixProduits->fetch();
   //$objValeurRecolter->closeCursor();
   //return $tableauValeurRecolter; // On retourne la valeur du champ PrixProduit
/*}*/
?>
