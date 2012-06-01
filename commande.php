               <?php include("header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page commande.php -->
            <p>
               Choisissez les produits ainsi que les quantités souhaités.<br />
            </p>
            <form method="post" action="traitement/traitement-commande.php">
              <p><label for="listeRestaurant">Choisissez un restaurant : </label>
              <select name="listeRestaurant" id="listeRestaurant">
              <!--On crée une ligne vide pour qu'il n'y est rien par defaut.-->
              <option value="Vide" selected="selected"></option>
<?php
               // On récupère les noms des objRestaurants, sinon il y aura une erreur explicite.
               $objNomRestaurants = $objBDD->query('SELECT NomRestaurant FROM Restaurants ORDER BY NomRestaurant') or die(print_r($objBDD->errorInfo()));
               // On affiche les noms des objRestaurants dans une liste déroulante.
               while ($strTableauNomRestaurants = $objNomRestaurants->fetch())
               {
                 echo '<option value="' . htmlspecialchars($strTableauNomRestaurants['NomRestaurant']) . '">' . htmlspecialchars($strTableauNomRestaurants['NomRestaurant']) . '</option>';
               }
               $objNomRestaurants->closeCursor(); // Termine le traitement de la requête
               echo '</select></p>';
               // Je boucle 5 fois pour crée 5 tableaux identique.
               for ($intCompteur=1;$intCompteur<=5;$intCompteur++)
               {
                 echo '<table>';
                 echo '<tr>';
                 echo '<td><label for="listeProduits' . $intCompteur . '">Choisissez un produit :</label></td>';
                 echo '<td><label for="QuantiteProduit' . $intCompteur . '">Quantité souhaité :</label></td>';
                 echo '<td><label for="PrixDuJour' . $intCompteur . '">Prix du jour :</label></td>';
                 echo '</tr>';
                 echo '<tr>';
                 echo '   <td>';
                 echo '<select name="listeProduits' . $intCompteur . '" id="listeProduits' . $intCompteur .'">';
                 // On crée une ligne vide pour qu'il n'y est rien par defaut.
                 echo '<option value="Vide" selected="selected"></option>';
                 // On récupère la liste des produits
                 $objProduits = $objBDD->query('SELECT DesignProduit FROM Produits ORDER BY DesignProduit') or die(print_r($objBDD->errorInfo()));
                 // On affiche les noms des restaurants dans une liste déroulante.
                 while ($strTableauProduits = $objProduits->fetch())
                 {
                   echo '<option value="' . htmlspecialchars($strTableauProduits['DesignProduit']) . '">' . htmlspecialchars($strTableauProduits['DesignProduit']) . '</option>';
                 }
                 $objProduits->closeCursor(); // Termine le traitement de la requête
                 echo '</select>';
                 echo '</td>';
                 // On demande la quantité et le prix du jour
                 echo '<td><input type="text" name="QuantiteProduit' . $intCompteur . '" id="QuantiteProduit' . $intCompteur . '" /></td>';
                 echo '<td><input type="text" name="PrixDuJour' . $intCompteur . '" id="PrixDuJour' . $intCompteur . '" /> €</td>';
                 echo '</tr>';
                 echo '</table>';
               }
?>
               <p class="centrer">
                  <input type="submit" value="Ajouter à la commande" />
               <p>
            </form>
         </div>
         <?php include("footer.php");?>
