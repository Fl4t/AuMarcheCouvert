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
            <p>
            <?php
               // affichage pour savoir si c'est fait.
               //echo '<pre>';
               //echo 'POST : <br />';
               //print_r($_POST);
               //echo '</pre>';
               
               // On apelle la fonction de transfert session <- post.
               $pute = PrixDuProduit(design1);
               echo $pute;
               //TransfertPostDansSession();
               //echo '<table>';
               //echo '<tr>';
               //echo '<td>Cette commande est préparé pour le restaurant <strong>' . $_SESSION['Restaurant'] . '</strong></td>';
               //echo '</tr>';
               //echo '<tr>';
               //echo '<td>Produits :</td>';
               //echo '<td>Quantité :</td>';
               //echo '<td>Prix Unitaire :</td>';
               //echo '<td>Prix hors taxes :</td>';
               //echo '</tr>';
               //// On affiche le panier.
               //$intNombreDeProduits = count($_SESSION['Panier']['DesignProduit']);
               //for($intAffichage;$intAffichage <= $intNombreDeProduits;$intAffichage++)
               //{
                  //echo '<tr>';
                  //echo '<td>' . $_SESSION['Panier']['DesignProduit'][$intAffichage] . '</td>';
                  //echo '<td>' . $_SESSION['Panier']['QuantiteProduit'][$intAffichage] . '</td>';
                  //echo '<td>' . $_SESSION['Panier']['PrixProduit'][$intAffichage] . '</td>';
                  //echo '<td>' . $_SESSION['Panier']['PrixProduit'][$intAffichage] * $_SESSION['Panier']['QuantiteProduit'][$intAffichage] . '</td>';
                  //echo '</tr>';
               //}
               //echo '</table>';
            ?>
            <p>
         </div>
         <?php include("footer.php");?>
