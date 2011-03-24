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

// Fonction P_ConnexionBDD
// On se connecte sur la base de donnée en passant par un essai
// affiche une erreur explicite.
function P_ConnexionBDD()
{
   try
   {
      $objBDD = new PDO('mysql:host=localhost;dbname=AuMarcheCouvert;', 'root', 'root');
   }
   catch(Exception $e)
   {
      die('Erreur : ' . $e->getMessage());
   }
}

// Fonction F_TransfertPostSession
// On affecte toutes les valeurs de la superglobale $_POST à $_SESSION si il sont valide. 
function F_TransfertPostDansSession()
{
   // Si le restaurant a été renseigné, on continue.
   if ($_POST['listeRestaurant'] != "Vide")
   {
      $_SESSION['NomRestaurant'] = $_POST['listeRestaurant'];
      
      for($NombreDeProduits=1;$NombreDeProduits<=5;$NombreDeProduits++)
      {
         // Si le produit a été séléctionné et qu'une quantité a été tapé et qu'elle est différente de zéro.
         if ($_POST['listeProduits' . $NombreDeProduits] != "Vide" AND $_POST['textQuantiteProduit' . $NombreDeProduits] != 0)
         {
            // On remplie le tableau 'DesignProduit' qui ce trouve lui même dans le tabeau à l'index 0 de 'Panier'
            $_SESSION['Panier']['DesignProduit'][$NombreDeProduits] = $_POST['listeProduits' . $NombreDeProduits];
            // On remplie le tableau 'QuantiteProduit' qui ce trouve lui même dans le tabeau à l'index 0 de 'Panier'
            // On force tout ce qui a pu être tapé en entier, si c'était autre chose qu'un entier, ça vaudra 0 
            $_SESSION['Panier']['QuantiteProduit'][$NombreDeProduits] = (integer) ($_POST['textQuantiteProduit' . $NombreDeProduits]);
         }
      }
   }

   // affichage pour savoir si c'est fait.
   echo '<pre>';
   echo 'SESSION : <br />';
   print_r($_SESSION);
   echo '</pre>';
}

////////// il faut faire une fonction qui corrige le panier si le mec il choisi le meme produit dans deux listes differentes
////////// regrouper les quantités quoi.
////////// Il faut faire aussi une fonction qui supprime les trous entre les enregistrement du tableau, (voir le cour d'algo)

/*// Fonction F_NomDuProduit */
//// Extrait de la base de donnée les noms des produits.
//function F_NomDuProduit()
//{
   //// On va lire sur la base de donnée pour en tirer les prix des Produits.
   //$objPrixProduits = $objBDD->query('SELECT PrixProduit FROM Produits') or die(print_r($objBDD->errorInfo()));
   //// On range les valeurs dans un tableau associatif
   //$dblTableauPrixProduits = $objPrixProduits->fetch();
   //$objPrixProduits->closeCursor(); // Termine le traitement de la requête
//}
  
//// Requete préparée.
//$objPrixProduits = $objBDD->prepare('SELECT PrixProduit FROM Produits WHERE DesignProduit = :NomProduit') or die(print_r($objBDD->errorInfo()));
//$dblTableauPrixProduits->execute(array('NomProduit' => $_SESSION['ListeProduits1']));
   



//// test //
//echo '<br/>';
//echo '<pre>';
//print_r($dblTableauPrixProduits);
/*echo '</pre>';*/
?>
