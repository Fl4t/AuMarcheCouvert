<?php include("header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
            </ul>
         </nav>
         <div id="texte">
            <?php
               if ($_POST['valider'] == "Oui")
               {
                  try
                  {
                     // Appel de la fonction F_CodeDuRestaurant
                     $intCodeRestaurant = F_CodeDuRestaurant($_SESSION['NomRestaurant']);
                     // On ajoute une entrée dans la table commande. Il n'y a rien a la première , car c'est auto-incrementé.
                     $objBDD->exec('INSERT INTO Commandes(NumCommande, CodeRestaurant, DateCommande) VALUES(\'\','.$intCodeRestaurant.',NOW())');
                     $intDerniereID = (integer) $objBDD->lastInsertId(); // On récupère la valeur de la dernière insertion id (string) car comme cetait en auto-increment, on ne connaissai pas la valeur.
                     for($intNombreDeProduits=1;$intNombreDeProduits <= $_SESSION['NombreDeProduits'];$intNombreDeProduits++)
                     {
                        // Je fais les insertions à l'aide d'une requête préparée.
                        $objPreparation = $objBDD->prepare('INSERT INTO Contenir(RefProduit, NumCommande, QteCommande, PrixDuJour) VALUES(:RefProduit, :NumCommande, :QteCommande, :PrixDuJour)');
                        $objPreparation->execute(array(
                           'RefProduit' => F_RefDuProduit($_SESSION['Panier']['DesignProduit'][$intNombreDeProduits]),
                           'NumCommande' => $intDerniereID,
                           'QteCommande' => $_SESSION['Panier']['QuantiteProduit'][$intNombreDeProduits],
                           'PrixDuJour' => $_SESSION['Panier']['PrixDuJour'][$intNombreDeProduits]));
                     }
                     echo '<p class="centrer">';
                     echo 'Commande ajoutée !';
                     echo '<br />';
                     echo '<a href=index.php>Retour à l\'index</a>';
                     echo '</p>';
                     // Détruit la variable SESSION puisque l'on à fini !
                     session_destroy();
                  }
                  catch(Exception $e)
                  {
                     die('Erreur : '.$e->getMessage());
                  }
               }
               else
               {
                  echo '<p class="centrer">';
                  echo 'Commande annulée.';
                  echo '<br />';
                  echo '<a href=index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("footer.php");?>
