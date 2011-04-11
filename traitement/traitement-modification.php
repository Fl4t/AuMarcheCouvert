<?php include("../header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li class="actif"><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="ajout.php">Modification</a></li>
               <li class="actif"><a href="modification.php">Modification</a></li>
               <li><a href="suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte-administration">
            <?php
               if ($_POST['modification'] == "restaurant")
               {
                  echo '<h2>Modification d\'un restaurant</h2>';
                  echo '<input type="text" name="NomRestaurant" id="NomRestaurant" /><label for="NomRestaurant">Nom du restaurant :</label><br />';
                  echo '<input type="text" name="Adr1Restaurant" id="Adr1Restaurant" /><label for="Adr1Restaurant">Adresse du restaurant (facultatif) :</label><br />';
                  echo '<input type="text" name="Adr2Restaurant" id="Adr2Restaurant" /><label for="Adr2Restaurant"></label><br />';
                  echo '<input type="text" name="CpRestaurant" id="CpRestaurant" /><label for="CpRestaurant">Code postal :</label><br />';
                  echo '<input type="text" name="VilleRestaurant" id="VilleRestaurant" /><label for="VilleRestaurant">Ville :</label><br />';
                  echo '<input type="text" name="MelRestaurant" id="MelRestaurant" /><label for="MelRestaurant">E-Mail (facultatif) :</label><br />';
                  echo '<input type="text" name="TelRestaurant" id="TelRestaurant" /><label for="TelRestaurant">Téléphone (facultatif) :</label><br />';
               }
               elseif ($_POST['modification'] == "produit")
               {
                  echo '<h2>Modification d\'un produit</h2>';
                  echo '<input type="text" name="DesignProduit" id="DesignProduit" /><label for="DesignProduit">Nom du produit :</label><br />';
                  echo '<input type="text" name="PrixProduit" id="PrixProduit" /><label for="PrixProduit">Prix moyen constaté :</label><br />';
                  echo '<input type="text" name="UniteVente" id="UniteVente" /><label for="UniteVente">Unité de vente (piece/kg) :</label><br />';
               }
               else
               {
                  echo '<p class="centrer">';
                  echo 'Modification annulée.';
                  echo '<br />';
                  echo '<a href=index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
