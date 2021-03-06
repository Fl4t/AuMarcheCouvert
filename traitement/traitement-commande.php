               <?php include("../header.php");?>
               <li><a href="../index.php">Accueil</a></li>
               <li class="actif"><a href="../commande.php">Nouvelle commande</a></li>
               <li><a href="../consultation.php">Consultation</a></li>
               <li><a href="../administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page traitement-commande.php -->
<?php
               P_TransfertPostDansSession(); // On apelle la fonction de transfert session <- post.
               // Pour un code moin lourd.
               $intNombreDeProduits = $_SESSION['NombreDeProduits'];
               if ($intNombreDeProduits != 0)
               {
                   $fltTotalHT = 0;
                   echo '<h3><strong>' . htmlspecialchars($_SESSION['NomRestaurant']) . '</strong></h3>';
                   echo '<table><thead>';
                   echo '<tr>';
                   echo '<td class="recapitulatif">Produits :</td>';
                   echo '<td class="recapitulatif">Quantité :</td>';
                   echo '<td class="recapitulatif">Prix du jour :</td>';
                   echo '<td class="recapitulatif">Prix HT :</td>';
                   echo '</tr>';
                   echo '</thead><tbody>';
                   // On affiche le panier.
                   for($intAffichage=1;$intAffichage<=$intNombreDeProduits;$intAffichage++)
                   {
                       echo '<tr>';
                       echo '<td class="recapitulatif">' . stripslashes(htmlspecialchars($_SESSION['Panier']['DesignProduit'][$intAffichage])) . '</td>';
                       echo '<td class="recapitulatif">' . htmlspecialchars($_SESSION['Panier']['QuantiteProduit'][$intAffichage]) . '</td>';
                       echo '<td class="recapitulatif">' . htmlspecialchars(number_format($_SESSION['Panier']['PrixDuJour'][$intAffichage], 2)) . ' €</td>';
                       echo '<td class="recapitulatif">' . htmlspecialchars(number_format($_SESSION['Panier']['PrixDuJour'][$intAffichage], 2))*htmlspecialchars(number_format($_SESSION['Panier']['QuantiteProduit'][$intAffichage], 2)) . ' €</td>';
                       echo '</tr>';
                       // Calcul du Prix Total
                       $fltTotalHT += htmlspecialchars($_SESSION['Panier']['PrixDuJour'][$intAffichage])*htmlspecialchars($_SESSION['Panier']['QuantiteProduit'][$intAffichage]);
                   }
                   echo '<tr>'; // on affiche le prix total HT.
                   echo '<td></td>';
                   echo '<td></td>';
                   echo '<td class="centrer"><b>Prix Total :</b></td>';
                   echo '<td class="centrer">' . number_format($fltTotalHT, 2) . ' €</td>';
                   echo '</tr>';
                   echo '</tbody></table>';
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
                   echo '<a href=../commande.php>Retour au formulaire de commande</a>';
                   echo '</p>';
               }
?>
         </div>
         <?php include("../footer.php");?>
