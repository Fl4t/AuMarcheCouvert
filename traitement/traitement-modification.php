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
         <div id="texte">
            <?php
               //
               // Première étape : Choix de modification pour un produit ou pour un restaurant.
               //
               if (isset($_POST['modification']))
               {
                  //
                  // Deuxième étape : Choix du restaurant ou du produit dans leurs listes réspectives.
                  //
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
                        echo '<option value="'.htmlspecialchars($strTableauNomRestaurants['NomRestaurant']).'">'.htmlspecialchars($strTableauNomRestaurants['NomRestaurant']).'</option>';
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
                        echo '<option value="'.htmlspecialchars($strTableauProduits['DesignProduit']).'">'.htmlspecialchars($strTableauProduits['DesignProduit']).'</option>';
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
                     echo '<a href=../index.php>Retour à l\'index</a>';
                     echo '</p>';
                  }
               }
               //
               // Troisième étape : Le choix est fait, on affiche les valeurs préalables.
               //
               elseif (isset($_POST['listeRestaurants']))
               {
                  // Sauvegarde du restaurant que l'on mets à jour, j'en ai besoin pour m'en souvenir à la page suivante.
                  $_SESSION['SauvegardeNomRestaurants'] = $_POST['listeRestaurants'];
                  // Appel de la fonction F_ValeurDuRestaurant.
                  $strValeurDuRestaurant = F_ValeurDuRestaurant($_POST['listeRestaurants']);
                  echo '<h2>Modification d\'un restaurant</h2>';
                  echo '<form method="POST" action="traitement-modification.php">';
                  echo '<table>';
                  echo '<tr><td><label for="NomRestaurant">Nom du restaurant :</label></td><td><input type="text" name="NomRestaurant" id="NomRestaurant" value="'.htmlspecialchars($strValeurDuRestaurant['NomRestaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="Adr1Restaurant">Adresse du restaurant (facultatif) :</label></td><td><input type="text" name="Adr1Restaurant" id="Adr1Restaurant"value="'.htmlspecialchars($strValeurDuRestaurant['Adr1Restaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="Adr2Restaurant"></label></td><td><input type="text" name="Adr2Restaurant" id="Adr2Restaurant" value="'.htmlspecialchars($strValeurDuRestaurant['Adr2Restaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="CpRestaurant">Code postal :</label></td><td><input type="text" name="CpRestaurant" id="CpRestaurant" value="'.htmlspecialchars($strValeurDuRestaurant['CpRestaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="VilleRestaurant">Ville :</label></td><td><input type="text" name="VilleRestaurant" id="VilleRestaurant" value="'.htmlspecialchars($strValeurDuRestaurant['VilleRestaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="MelRestaurant">E-Mail (facultatif) :</label></td><td><input type="text" name="MelRestaurant" id="MelRestaurant" value="'.htmlspecialchars($strValeurDuRestaurant['MelRestaurant']).'"/></td></tr>';
                  echo '<tr><td><label for="TelRestaurant">Téléphone (facultatif) :</label></td><td><input type="text" name="TelRestaurant" id="TelRestaurant" value="'.htmlspecialchars($strValeurDuRestaurant['TelRestaurant']).'"/></td></tr>';
                  echo '</table>';
                  echo '<center><input type="submit" value="Modifier" /></center>';
                  echo '</form>';
               }
               elseif (isset($_POST['listeProduits']))
               {
                  // Sauvegarde du produit que l'on mets à jour, j'en ai besoin pour m'en souvenir à la page suivante.
                  $_SESSION['SauvegardeNomProduits'] = $_POST['listeProduits'];
                  $strValeurDuProduit = F_ValeurDuProduit($_POST['listeProduits']);
                  echo '<h2>Modification d\'un produit</h2>';
                  echo '<form method="POST" action="traitement-modification.php">';
                  echo '<table>';
                  echo '<tr><td><label for="DesignProduit">Nom du produit :</label></td><td><input type="text" name="DesignProduit" id="DesignProduit" value="'.htmlspecialchars($strValeurDuProduit['DesignProduit']).'"/></td></tr>';
                  echo '<tr><td><label for="PrixProduit">Prix moyen constaté :</label></td><td><input type="text" name="PrixProduit" id="PrixProduit" value="'.htmlspecialchars($strValeurDuProduit['PrixProduit']).'"/></td></tr>';
                  echo '<tr><td><label for="UniteVente">Unité de vente :</label></td>';
                  echo '<td><select name="UniteVente" id="UniteVente">';
                  echo '<option value="unite">à l\'unité</option>';
                  echo '<option value="kilo">au kilo</option>';
                  echo '</select></td></tr></table>';
                  echo '<center><input type="submit" value="Modifier" /></center>';
                  echo '</form>';
               }
               //
               // Quatrième étape : Les changements sont fait, on mets à jour.
               //
               elseif (isset($_POST['NomRestaurant']))
               {
                  P_MAJRestaurant(stripslashes($_SESSION['SauvegardeNomRestaurants']), stripslashes($_POST['NomRestaurant']), stripslashes($_POST['Adr1Restaurant']), stripslashes($_POST['Adr2Restaurant']), stripslashes($_POST['CpRestaurant']), stripslashes($_POST['VilleRestaurant']), stripslashes($_POST['MelRestaurant']),stripslashes($_POST['TelRestaurant']));
                  // detruit la session car j'en ai pas besoin plus longtemps
                  session_destroy();
                  echo '<p class="centrer">';
                  echo 'Modification du restaurant reussi !';
                  echo '<br />';
                  echo '<a href=../index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
               elseif (isset($_POST['DesignProduit']))
               {
                  P_MAJProduit(stripslashes($_SESSION['SauvegardeNomProduits']), stripslashes($_POST['DesignProduit']), stripslashes($_POST['PrixProduit']), stripslashes($_POST['UniteVente']));
                  // detruit la session car j'en ai pas besoin plus longtemps
                  session_destroy();
                  echo '<p class="centrer">';
                  echo 'Modification du produit reussi !';
                  echo '<br />';
                  echo '<a href=../index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
