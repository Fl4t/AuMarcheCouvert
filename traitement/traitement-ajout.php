<?php include("../header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li class="actif"><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li class="actif"><a href="ajout.php">Ajout</a></li>
               <li><a href="modification.php">Modification</a></li>
               <li><a href="suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte-administration">
            <!-- Pour éviter de crée des fichiers traitement-ajout-produit.php et traitement-ajout-restaurant.php, je l'apelle lui-même. -->
            <form method="POST" action="traitement-ajout.php">
               <?php
                  if ($_POST['ajout'] == "restaurant")
                  {
                     echo '<h2>Ajout d\'un restaurant</h2>';
                     echo '<input type="text" name="NomRestaurant" id="NomRestaurant" /><label for="NomRestaurant">Nom du restaurant :</label><br />';
                     echo '<input type="text" name="Adr1Restaurant" id="Adr1Restaurant" /><label for="Adr1Restaurant">Adresse du restaurant (facultatif) :</label><br />';
                     echo '<input type="text" name="Adr2Restaurant" id="Adr2Restaurant" /><label for="Adr2Restaurant"></label><br />';
                     echo '<input type="text" name="CpRestaurant" id="CpRestaurant" /><label for="CpRestaurant">Code postal :</label><br />';
                     echo '<input type="text" name="VilleRestaurant" id="VilleRestaurant" /><label for="VilleRestaurant">Ville :</label><br />';
                     echo '<input type="text" name="MelRestaurant" id="MelRestaurant" /><label for="MelRestaurant">E-Mail (facultatif) :</label><br />';
                     echo '<input type="text" name="TelRestaurant" id="TelRestaurant" /><label for="TelRestaurant">Téléphone (facultatif) :</label><br />';
                  }
                  elseif ($_POST['ajout'] == "produit")
                  {
                     echo '<h2>Ajout d\'un produit</h2>';
                     echo '<input type="text" name="DesignProduit" id="DesignProduit" /><label for="DesignProduit">Nom du produit :</label><br />';
                     echo '<input type="text" name="PrixProduit" id="PrixProduit" /><label for="PrixProduit">Prix moyen constaté :</label><br />';
                     echo '<input type="text" name="UniteVente" id="UniteVente" /><label for="UniteVente">Unité de vente (piece/kg) :</label><br />';
                  }
                  else
                  {
                     echo '<p class="centrer">';
                     echo 'Ajout annulée.';
                     echo '<br />';
                     echo '<a href=index.php>Retour à l\'index</a>';
                     echo '</p>';
                  }

                  if (isset($_POST['nomRestaurant']))
                  {
                     if (empty($_POST['nomRestaurant']) || empty($_POST['CpRestaurant']) || empty($_POST['VilleRestaurant']))
                     {
                        echo '<p class="centrer">';
                        echo 'Le nom, le code postal et la ville sont obligatoire pour un ajout de restaurant.';
                        echo '<br />';
                        echo '<a href=traitement-ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                     else
                     {
                        // On apelle la procédure paramétrée P_AjoutRestaurant.
                        P_AjoutRestaurant($_POST['nomRestaurant'],$_POST['Adr1Restaurant'],$_POST['Adr2Restaurant'],$_POST['CpRestaurant'],$_POST['VilleRestaurant'],$_POST['MelRestaurant'],$_POST['TelRestaurant']);
                     }
                  }
                  elseif (isset($_POST['DesignProduit']))
                  {
                     if (empty($_POST['DesignProduit']) || empty($_POST['PrixProduit']) || empty($_POST['PrixDuJour']))
                     {
                        echo '<p class="centrer">';
                        echo 'Le nom, le prix moyen et l\'unité de vente sont obligatoire pour un ajout de produit.';
                        echo '<br />';
                        echo '<a href=traitement-ajout.php>Retour à l\'ajout</a>';
                        echo '</p>';
                     }
                     else
                     {
                        // On apelle la procédure paramétrée P_AjoutProduit.
                        P_AjoutProduit($_POST['DesignProduit'],$_POST['PrixProduit'],$_POST['PrixDuJour']);
                     }
                  }
               ?>
            </form>
         </div>
         <?php include("../footer.php");?>
