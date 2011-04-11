               <?php include("header.php");?>
               <li><a href="index.php">Acceuil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page commander.php --> 
            <p>
               Choisissez les produits ainsi que les quantités souhaités.<br />
            </p>
            <form method="post" action="traitement-commande.php">
               <p> 
                  <label for="listeRestaurant">Choisissez un restaurant : </label>
                  <select name="listeRestaurant" id="listeRestaurant">
                     <?php
                        // On crée une ligne vide pour qu'il n'y est rien par defaut.
                        echo '<option value="Vide" selected="selected"></option>';
                        
                        // On récupère les noms des objRestaurants, sinon il y aura une erreur explicite.
                        $objNomRestaurants = $objBDD->query('SELECT NomRestaurant FROM restaurants') or die(print_r($objBDD->errorInfo()));
                        
                        // On affiche les noms des objRestaurants dans une liste déroulante.
                        while ($strTableauNomRestaurants = $objNomRestaurants->fetch())
                        {
                           echo '<option value="' . $strTableauNomRestaurants['NomRestaurant'] . '">' . $strTableauNomRestaurants['NomRestaurant'] . '</option>';
                        }
                        $objNomRestaurants->closeCursor(); // Termine le traitement de la requête
                     ?>
                  </select>
               </p> 
               <?php
                  // Je boucle 5 fois pour crée 5 tableaux HTML identique.
                  for ($intCompteur=1;$intCompteur<=5;$intCompteur++)
                  {
               ?>
               <table>
                  <tr>
                     <td class="equilibrage" rowspan="2"></td>
                     <?php
                        echo '<td><label for="listeProduits' . $intCompteur . '">Choisissez un produit :</label></td>';
                        echo '<td><label for="QuantiteProduit' . $intCompteur . '">Quantité souhaité :</label></td>';
                        echo '<td><label for="PrixDuJour' . $intCompteur . '">Prix du jour :</label></td>';
                     ?>
                     <td class="equilibrage" rowspan="2"></td>
                  </tr>
                  <tr>
                     <td>
                        <?php
                           echo '<select name="listeProduits' . $intCompteur . '" id="listeProduits' . $intCompteur .'">';
                           // On crée une ligne vide pour qu'il n'y est rien par defaut.
                           echo '<option value="Vide" selected="selected"></option>';
                           
                           // On récupère la liste des produits, sinon il y aura une erreur explicite.
                           $objProduits = $objBDD->query('SELECT DesignProduit FROM Produits') or die(print_r($objBDD->errorInfo()));
                           
                           // On affiche les noms des Restaurants dans une liste déroulante.
                           while ($strTableauProduits = $objProduits->fetch())
                           {
                              echo '<option value="' . $strTableauProduits['DesignProduit'] . '">' . $strTableauProduits['DesignProduit'] . '</option>';
                           }
                           $objProduits->closeCursor(); // Termine le traitement de la requête
                           echo '</select>';
                        ?>
                     </td>
                     <!-- On demande la quantité et le prix du jour -->
                     <?php
                        echo '<td><input type="text" name="QuantiteProduit' . $intCompteur . '" id="QuantiteProduit' . $intCompteur . '" /></td>';
                        echo '<td><input type="text" name="PrixDuJour' . $intCompteur . '" id="PrixDuJour' . $intCompteur . '" /></td>';
                     ?>   
                  </tr>
               </table>
               <?php
                  }
               ?>
               <p>
                  <br />
                  <center><input type="submit" value="Ajouter à la commande" /></center>
               <p>
            </form>
         </div>
         <?php include("footer.php");?>
