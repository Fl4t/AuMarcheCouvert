               <?php include("header.php");?>
               <li><a href="index.php">Acceuil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle Commande</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page commander.php --> 
            <p>
               Choisissez les produits ainsi que les quantités souhaités.<br />
            </p>
            <form method="post" action="traitement-commande.php">
               <p> 
                  <label for="restaurants">Choisissez un restaurant : </label>
                  <select name="restaurants">
                     <?php
                        // On crée une ligne vide pour qu'il n'y est rien par defaut.
                        echo '<option value="vide" selected="selected"></option>';
                        
                        // On récupère les noms des restaurants, sinon il y aura une erreur explicite.
                        $restaurants = $bdd->query('SELECT NomRestaurant FROM Restaurants') or die(print_r($bdd->errorInfo()));
                        
                        // On affiche les noms des restaurants dans une liste déroulante.
                        while ($donnees = $restaurants->fetch())
                        {
                           echo '<option value="' . $donnees['NomRestaurant'] . '">' . $donnees['NomRestaurant'] . '</option>';
                        }
                        $restaurants->closeCursor(); // Termine le traitement de la requête
                     ?>
                  </select>
               </p> 
               <?php
                  // Je boucle 5 fois pour crée 5 tableaux.
                  for($intCompteurProduit=1;$intCompteurProduit=5;$intCompteurProduit++)
                  {
               ?>
               <table>
                  <tr>
                     <td class="equilibrage" rowspan="2"></td>
                     <td><label for="produits">Choisissez un produit :</label></td>
                     <td class="equilibrage" rowspan="2"></td>
                     <td><label for="quantiteproduit">Quantité souhaité :</label></td>
                     <td class="equilibrage" rowspan="2"></td>
                  </tr>
                  <tr>
                     <td>
                        <?php
                           echo '<select name="Produit' . $intCompteurProduit . '">';
                           // On crée une ligne vide pour qu'il n'y est rien par defaut.
                           echo '<option value="vide" selected="selected"></option>';
                           
                           // On récupère la liste des produits, sinon il y aura une erreur explicite.
                           $produits = $bdd->query('SELECT DesignProduit FROM Produits') or die(print_r($bdd->errorInfo()));
                           
                           // On affiche les noms des restaurants dans une liste déroulante.
                           while ($donnees = $produits->fetch())
                           {
                           echo '<option value="' . $donnees['DesignProduit'] . '">' . $donnees['DesignProduit'] . '</option>';
                           }
                           $produits->closeCursor(); // Termine le traitement de la requête
                           echo '</select>';
                        ?>
                     </td>
                     <!-- On demande la quantité -->
                     <?php
                        echo '<td><input type="text" name="Quantiteproduit' . $intCompteurProduit . '" /></td>'
                     ?>   
                  </tr>
               </table>
               <?php
                  }
               ?>
               <br />
               <center><input type="submit" value="Ajouter à la commande" /></center>
            </form>
         </p>
         </div>
         <?php include("footer.php");?>
