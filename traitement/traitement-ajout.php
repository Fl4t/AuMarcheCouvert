<?php include("../header.php");?>
               <li><a href="http://localhost:8888/AuMarcheCouvert/index.php">Accueil</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/commande.php">Nouvelle Commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/consultation.php">Consultation</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/ajout.php">Ajout</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/modification.php">Modification</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte">
            <!-- Pour éviter de crée des fichiers traitement-ajout-produit.php et traitement-ajout-restaurant.php, je l'apelle lui-même
            à chaque étape du traitement. -->
            <form method="POST" action="traitement-ajout.php">
               <?php
                  if (isset($_POST['ajout']))
                  {
                     if ($_POST['ajout'] == "restaurant")
                     {
                        echo '<h2 class="centrer">Ajout d\'un restaurant</h2>';
                        echo '<br />';
                        echo '<table>';
                        echo '<tr><td><label for="NomRestaurant">Nom du restaurant :</label></td><td><input type="text" name="NomRestaurant" id="NomRestaurant" /></td></tr>';
                        echo '<tr><td><label for="Adr1Restaurant">Adresse du restaurant (facultatif) :</label></td><td><input type="text" name="Adr1Restaurant" id="Adr1Restaurant" /></td></tr>';
                        echo '<tr><td><label for="Adr2Restaurant"></label></td><td><input type="text" name="Adr2Restaurant" id="Adr2Restaurant" /></td></tr>';
                        echo '<tr><td><label for="CpRestaurant">Code postal :</label></td><td><input type="text" name="CpRestaurant" id="CpRestaurant" /></td></tr>';
                        echo '<tr><td><label for="VilleRestaurant">Ville :</label></td><td><input type="text" name="VilleRestaurant" id="VilleRestaurant" /></td></tr>';
                        echo '<tr><td><label for="MelRestaurant">E-Mail (facultatif) :</label></td><td><input type="text" name="MelRestaurant" id="MelRestaurant" /></td></tr>';
                        echo '<tr><td><label for="TelRestaurant">Téléphone (facultatif) :</label></td><td><input type="text" name="TelRestaurant" id="TelRestaurant" /></td></tr>';
                        echo '</table>';
                        echo '<br />';
                        echo '<center><input type="submit" value="Ajouter" /></center>';
                     }
                     elseif ($_POST['ajout'] == "produit")
                     {
                        echo '<h2 class="centrer">Ajout d\'un produit</h2>';
                        echo '<br />';
                        echo '<table>';
                        echo '<tr><td><label for="DesignProduit">Nom du produit :</label></td><td><input type="text" name="DesignProduit" id="DesignProduit" /></td></tr>';
                        echo '<tr><td><label for="PrixProduit">Prix moyen constaté :</label></td><td><input type="text" name="PrixProduit" id="PrixProduit" /></td></tr>';
                        echo '<tr><td><label for="UniteVente">Unité de vente :</label></td>';
                        echo '<td><select name="UniteVente" id="UniteVente">';
                        echo '<option value="unite">à l\'unité</option>';
                        echo '<option value="kilo">au kilo</option>';
                        echo '</select></td></tr></table>';
                        echo '<br />';
                        echo '<center><input type="submit" value="Ajouter" /></center>';
                     }
                     else
                     {
                        echo '<p class="centrer">';
                        echo 'Il faut faire un choix !';
                        echo '<br />';
                        echo '<a href=../ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                  }
                  //affichage pour savoir si c'est fait.
                  echo '<pre>';
                  echo 'POST : <br />';
                  print_r($_POST);
                  echo '</pre>';
                  if (isset($_POST['NomRestaurant']))
                  {
                     if (empty($_POST['NomRestaurant']) || empty($_POST['CpRestaurant']) || empty($_POST['VilleRestaurant']))
                     {
                        echo '<p class="centrer">';
                        echo 'Le nom, le code postal et la ville sont obligatoire pour un ajout de restaurant.';
                        echo '<br />';
                        echo '<a href=../ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                     else
                     {
                        // On apelle la procédure paramétrée P_AjoutRestaurant.
                        P_AjoutRestaurant(stripslashes($_POST['NomRestaurant']),stripslashes($_POST['Adr1Restaurant']),stripslashes($_POST['Adr2Restaurant']),stripslashes($_POST['CpRestaurant']),stripslashes($_POST['VilleRestaurant']),stripslashes($_POST['MelRestaurant']),stripslashes($_POST['TelRestaurant']));
                        echo '<p class="centrer">';
                        echo 'Restaurant ajouté !';
                        echo '<br />';
                        echo '<a href=../ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                  }
                  elseif (isset($_POST['DesignProduit']))
                  {
                     if (empty($_POST['DesignProduit']) || empty($_POST['PrixProduit']) || empty($_POST['UniteVente']))
                     {
                        echo '<p class="centrer">';
                        echo 'Le nom, le prix moyen et l\'unité de vente sont obligatoire pour un ajout de produit.';
                        echo '<br />';
                        echo '<a href=../ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                     else
                     {
                        // On apelle la procédure paramétrée P_AjoutProduit.
                        // On gère le cas ou une virgule est insérée.
                        $_POST['PrixProduit'] = preg_replace('#,#','.',$_POST['PrixProduit']);
                        P_AjoutProduit(stripslashes($_POST['DesignProduit']),stripslashes($_POST['PrixProduit']),stripslashes($_POST['UniteVente']));
                        echo '<p class="centrer">';
                        echo 'Produit ajouté !';
                        echo '<br />';
                        echo '<a href=../ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                  }
               ?>
            </form>
         </div>
         <?php include("../footer.php");?>
