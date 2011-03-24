               <?php include("header.php");?>
               <li><a href="index.php">Acceuil</a></li>
               <li class="actif"><a href="commande.php">Nouvelle Commande</a></li>
            </ul>
         </nav>
         <div id="texte">
            <!-- Contenu de la page traitement-commande.php --> 
            <p>
               Veuillez-vérifiez les informations précédemment choisi :
            </p>
            <?php
               // affichage pour savoir si c'est fait.
               echo '<pre>';
               echo 'POST : <br />';
               print_r($_POST);
               echo '</pre>';
               
               // On apelle la fonction de transfert session <- post.
               F_TransfertPostDansSession();
               // On utilise la fonction array_count() pour savoir combien de produits sont valides.
               $intNombreDeProduitsValide = array_count($_SESSION['panier']['DesignProduit']); 
               echo $intNombreDeProduitsValide;
               //for ($intAffichageProduit;$intNombreDeProduitsValide;$intAffichageProduit++)
               //{
                  //if (isset($_SESSION['']
                  //// Si la quantité est au dessus de 1 et que c'est raisonable, on affiche dans un tableau HTML.
                  //if (isset($_SESSION['textQuantiteProduit1']) >= 1 AND $_SESSION['textQuantiteProduit1'] <= 100)
                  //{
                     //// Si on est dans la fourchette de valeurs.
                     //$fltPrixHT = PrixListeProduits1('ListeProduits1') * $_SESSION['QantiteListeProduits1'];
                     //echo '<table>';
                     //echo '<tr>';
                     //echo '<td>' . $_SESSION['ListeProduits1'] . '</td>';
                     //echo '<td>' . $_SESSION['QantiteListeProduits1'] . '</td>';
                     //echo '<td>' . $fltPrixHT . '<td>';
                     //echo '</tr>';
                     //echo '</table>';
                  //}
                  //else
                  //{
                     //// Soit c'est 0 soit on est au dessus de 100.
                     //echo 'pas raisonable !';
                  //}
               //}
            ?>
         </div>
         <?php include("footer.php");?>
