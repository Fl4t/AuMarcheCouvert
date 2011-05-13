<?php include("../header.php");?>
               <li><a href="http://localhost:8888/AuMarcheCouvert/index.php">Accueil</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/commande.php">Nouvelle Commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/consultation.php">Consultation</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="http://localhost:8888/AuMarcheCouvert/ajout.php">Ajout</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/suppression.php">suppression</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte">
            <?php
               if (isset($_POST['suppression']))
               {
                  //
                  // Deuxième étape : Choix du restaurant ou du produit dans leurs listes réspectives.
                  //
                  if ($_POST['suppression'] == "restaurant")
                  {
                     echo '<form method="POST" action="traitement-suppression.php">';
                     echo '<p><label for="listeRestaurants">Choisissez un restaurant : </label>';
                     echo '<select name="listeRestaurants" id="listeRestaurants">';
                     // On crée une ligne vide pour qu'il n'y est rien par defaut.
                     echo '<option value="Vide" selected="selected"></option>';
                     // On récupère les noms des objRestaurants, sinon il y aura une erreur explicite.
                     $objNomRestaurants = $objBDD->query('SELECT NomRestaurant FROM Restaurants ORDER BY NomRestaurant') or die(print_r($objBDD->errorInfo()));
                     // On affiche les noms des objRestaurants dans une liste déroulante.
                     while ($strNomRestaurants = $objNomRestaurants->fetch())
                     {
                        echo '<option value="' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '">' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '</option>';
                     }
                     $objNomRestaurants->closeCursor(); // Termine le traitement de la requête
                     echo '</select><br />';
                     echo '<input type="submit" value="Continuer" />';
                     echo '</p></form>';
                  }
                  elseif ($_POST['suppression'] == "produit")
                  {
                     echo '<form method="POST" action="traitement-suppression.php">';
                     echo '<p><label for="listeProduits">Choisissez un produit : </label>';
                     echo '<select name="listeProduits" id="listeProduits">';
                     // On crée une ligne vide pour qu'il n'y est rien par defaut.
                     echo '<option value="Vide" selected="selected"></option>';
                     // On récupère la liste des produits, sinon il y aura une erreur explicite.
                     $objProduits = $objBDD->query('SELECT DesignProduit FROM Produits ORDER BY DesignProduit') or die(print_r($objBDD->errorInfo()));
                     // On affiche les noms des Restaurants dans une liste déroulante.
                     while ($strNomProduits = $objProduits->fetch())
                     {
                        echo '<option value="' . htmlspecialchars($strNomProduits['DesignProduit']) . '">' . htmlspecialchars($strNomProduits['DesignProduit']) . '</option>';
                     }
                     $objProduits->closeCursor(); // Termine le traitement de la requête
                     echo '</select><br />';
                     echo '<input type="submit" value="Continuer" />';
                     echo '</p></form>';
                  }
                  else
                  {
                     echo '<p class="centrer">';
                     echo 'Vous devez séléctionner une des possibilités.';
                     echo '<br />';
                     echo '<a href=../traitement-suppression.php>Retour aux suppressions</a>';
                     echo '</p>';
                  }
               }
               elseif (isset($_POST['listeRestaurants']))
               {
                  // On apelle la procédure de suppression du restaurant
                  P_SuppressionRestaurant(stripslashes($_POST['listeRestaurants']));
                  echo '<p class="centrer">';
                  echo 'Le restaurant a été supprimé !';
                  echo '<br />';
                  echo '<a href=../traitement-suppression.php>Retour aux suppressions</a>';
                  echo '</p>';
               }
               elseif (isset($_POST['listeProduits']))
               {
                  // On apelle la procédure de suppression du produit
                  P_SuppressionProduit(stripslashes($_POST['listeProduits']));
                  echo '<p class="centrer">';
                  echo 'Le produit a été supprimé !';
                  echo '<br />';
                  echo '<a href=../index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
