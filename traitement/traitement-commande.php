               <?php include("../header.php");?>
               <li><a href="index.php">Acceuil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page traitement-commande.php --> 
            <?php
               // affichage pour savoir si c'est fait.
               //echo '<pre>';
               //echo 'POST : <br />';
               //print_r($_POST);
               //echo '</pre>';
               P_TransfertPostDansSession(); // On apelle la fonction de transfert session <- post.
               // Pour un code moin lourd.
               $intNombreDeProduits = $_SESSION['NombreDeProduits'];             
               if ($intNombreDeProduits != 0) 
               {
                  echo '<table>';
                  echo '<h3><strong>' . $_SESSION['NomRestaurant'] . '</strong></h3>';
                  echo '<thead>';
                  echo '<tr>';
                  echo '<td class="recapitulatif">Produits :</td>';
                  echo '<td class="recapitulatif">Quantité :</td>';
                  echo '<td class="recapitulatif">Prix du jour :</td>';
                  echo '<td class="recapitulatif">Prix HT :</td>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                  // On affiche le panier.
                  for($intAffichage=1;$intAffichage <= $intNombreDeProduits -1;$intAffichage++)
                  {
                     echo '<tr>';
                     echo '<td class="recapitulatif">' . $_SESSION['Panier']['DesignProduit'][$intAffichage] . '</td>';
                     echo '<td class="recapitulatif">' . $_SESSION['Panier']['QuantiteProduit'][$intAffichage] . '</td>';
                     echo '<td class="recapitulatif">' . $_SESSION['Panier']['PrixDuJour'][$intAffichage] . '</td>';
                     echo '<td class="recapitulatif">' . $_SESSION['Panier']['PrixDuJour'][$intAffichage] * $_SESSION['Panier']['QuantiteProduit'][$intAffichage] . '</td>';
                     echo '</tr>';
                  }
               echo '<tr>'; // on affiche le dernier séparement pour ne pas avoir de border-bottom.
               echo '<td class="centrer">' . $_SESSION['Panier']['DesignProduit'][$intNombreDeProduits] . '</td>';
               echo '<td class="centrer">' . $_SESSION['Panier']['QuantiteProduit'][$intNombreDeProduits] . '</td>';
               echo '<td class="centrer">' . $_SESSION['Panier']['PrixDuJour'][$intNombreDeProduits] . '</td>';
               echo '<td class="centrer">' . $_SESSION['Panier']['PrixDuJour'][$intNombreDeProduits] * $_SESSION['Panier']['QuantiteProduit'][$intNombreDeProduits] . '</td>';
               echo '</tr>';
               echo '</tbody>';
               echo '</table>';
               //formulaire de test pour ecrire la commande dans la base de donnée
               ?>
               <form method="post" action="traitement-valider.php">
                  <p class="centrer">
                     Voulez-vous valider la commande ?<br />
                     <input type="radio" name="valider" value="Non" id="Non" /><label for="Non">Non</label><br />
                     <input type="radio" name="valider" value="Oui" id="Oui" /><label for="Oui">Oui</label>
                     <br />
                     <input type="submit" value="Continuer" /></center>
                  </p>
               </form>
            <?php
               } 
               else 
               {
                  echo '<p class="centrer">';
                  echo 'Les champs n\'ont pas été correctement saisis.';
                  echo '<br />';
                  echo '<a href=commande.php>Retour au formulaire de commande</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
