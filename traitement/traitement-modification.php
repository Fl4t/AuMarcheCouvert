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
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/modification.php">Modification</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte-administration">
            <?php
               if (isset($_POST['modification']))
               {
                  if ($_POST['modification'] == "restaurant")
                  {
                     echo '<form method="POST" action="traitement-modification.php">';
                     echo '<p><label for="listeRestaurants">Choisissez un restaurant : </label>';
                     echo '<select name="listeRestaurants" id="listeRestaurants">';
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
                     echo '</select><br />';
                     echo '<input type="submit" value="Continuer" />';
                     echo '</p></form>';
                  }
                  elseif ($_POST['modification'] == "produit")
                  {
                     echo '<form method="POST" action="traitement-modification.php">';
                     echo '<p><label for="listeProduits">Choisissez un produit : </label>';
                     echo '<select name="listeProduits" id="listeProduits">';
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
                     echo '</select><br />';
                     echo '<input type="submit" value="Continuer" />';
                     echo '</p></form>';
                  }
                  else
                  {
                     echo '<p class="centrer">';
                     echo 'Vous devez séléctionner une des possibilités.';
                     echo '<br />';
                     echo '<a href=index.php>Retour à l\'index</a>';
                     echo '</p>';
                  }
               }
               elseif (isset($_POST['listeRestaurants']))
               {
                  // Appel de la fonction F_ValeurDuRestaurant.
                  $strValeurDuRestaurant = F_ValeurDuRestaurant($_POST['listeRestaurants']);
                  echo '<h2>Modification d\'un restaurant</h2>';
                  echo '<form method="POST" action="traitement-modification.php">';
                  echo '<table>';
                  echo '<tr><td><label for="NomRestaurant">Nom du restaurant :</label></td><td><input type="text" name="NomRestaurant" id="NomRestaurant" value="'.$strValeurDuRestaurant['NomRestaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="Addr1Restaurant">Adresse du restaurant (facultatif) :</label></td><td><input type="text" name="Addr1Restaurant" id="Addr1Restaurant"value="'.$strValeurDuRestaurant['Addr1Restaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="Addr2Restaurant"></label></td><td><input type="text" name="Addr2Restaurant" id="Addr2Restaurant" value="'.$strValeurDuRestaurant['Addr2Restaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="CpRestaurant">Code postal :</label></td><td><input type="text" name="CpRestaurant" id="CpRestaurant" value="'.$strValeurDuRestaurant['CpRestaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="VilleRestaurant">Ville :</label></td><td><input type="text" name="VilleRestaurant" id="VilleRestaurant" value="'.$strValeurDuRestaurant['VilleRestaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="MelRestaurant">E-Mail (facultatif) :</label></td><td><input type="text" name="MelRestaurant" id="MelRestaurant" value="'.$strValeurDuRestaurant['MelRestaurant'].'"/></td></tr>';
                  echo '<tr><td><label for="TelRestaurant">Téléphone (facultatif) :</label></td><td><input type="text" name="TelRestaurant" id="TelRestaurant" value="'.$strValeurDuRestaurant['TelRestaurant'].'"/></td></tr>';
                  echo '</table>';
                  echo '<center><input type="submit" value="Modifier" /></center>';
                  echo '</form>';
               }
               elseif (isset($_POST['listeProduits']))
               {
                  $strValeurDuProduit = F_ValeurDuProduit($_POST['listeProduits']);
                  echo '<h2>Modification d\'un produit</h2>';
                  echo '<form method="POST" action="traitement-modification.php">';
                  echo '<table>';
                  echo '<tr><td><label for="DesignProduit">Nom du produit :</label></td><td><input type="text" name="DesignProduit" id="DesignProduit" value="'.$strValeurDuProduit['DesignProduit'].'"/></td></tr>';
                  echo '<tr><td><label for="PrixProduit">Prix moyen constaté :</label></td><td><input type="text" name="PrixProduit" id="PrixProduit" value="'.$strValeurDuProduit['PrixProduit'].'"/></td></tr>';
                  echo '<tr><td><label for="UniteVente">Unité de vente :</label></td>';
                  echo '<td><select name="UniteVente" id="UniteVente">';
                  echo '<option value="unite">à l\'unité</option>';
                  echo '<option value="kilo">au kilo</option>';
                  echo '</select></td></tr></table>';
                  echo '<center><input type="submit" value="Modifier" /></center>';
                  echo '</form>';
                                                                  /////// suite du travail, revoir les procédures de MAJ car il faut le précédent 
                                                                  /////// produit séléctionné, et la suite ici aussi a faire.
               }
            ?>
         </div>
         <?php include("../footer.php");?>
