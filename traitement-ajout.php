<?php include("header.php");?>
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
            <?php
               if ($_POST['ajout'] == "restaurant")
               {
                  echo '<h2>Restaurant</h2>';
                  echo '<input type="text" name="AjoutRestaurant" id="AjoutRestaurant" /><label for="AjoutRestaurant">Nom du restaurant :</label><br />';
               }
               elseif ($_POST['ajout'] == "produit")
               {
                  echo '<h2>Produits</h2>';
                  echo '<input type="text" name="AjoutProduit" id="AjoutProduit" /><label for="AjoutProduit">Nom du produit :</label><br />';
               }
               else
               {
                  echo '<p class="centrer">';
                  echo 'Ajout annulée.';
                  echo '<br />';
                  echo '<a href=index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("footer.php");?>
