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
               // On va lire sur la base de donnée pour en tirer le prix du produit1.
               $PrixProduit1 = $bdd->prepare('SELECT PrixProduit FROM Produits WHERE DesignProduit = :produit1') or die(print_r($bdd->errorInfo()));
               $PrixProduit1->execute(array('produit1' => $_SESSION['Produit1']));
               
               // Il y a 5 produits et quantités potentiels toute nommée de la meme façon sauf
               // que la fin est incrémenté.
               //$intCompteur = 0;
               //while(compteur <= 5)
               //{
                  //$Compteur = $Compteur + 1
                     if (isset($_SESSION['Produit1']) AND isset($_SESSION['QuantiteProduit1']))
                     {
                        // On rend inoffensive les balises HTML que l'utilisateur a pu entrer.
                        $_SESSION['Produit1'] = htmlspecialchars($_SESSION['Produit1']);
                        $_SESSION['QuantiteProduit1'] = htmlspecialchars($_SESSION['QuantiteProduit1']);
                        
                        // On test si c'est bien un entier qui a été entré.
                        // Ce test est fait par le mot-clé (integer) qui renvoie 0 si c'est autre chose qu'un entier.
                        $_SESSION['QuantiteProduit1'] = (integer) $_SESSION['QuantiteProduit1'];
                        
                        // Si la quantité est au dessus de 1 et que c'est raisonable, on affiche dans un tableau HTML.
                        if ($_SESSION['QuantiteProduit1'] > 0 AND $_SESSION['QuantiteProduit1'] <= 1OO)
                        {
                           // Si on est dans la fourchette de valeurs.
                           $fltPrixHT = PrixProduit1('produit1') * $_SESSION['QantiteProduit1'];
                           echo '<table>';
                           echo '<tr>';
                           echo '<td>' . $_SESSION['Produit1'] . '</td>';
                           echo '<td>' . $_SESSION['QantiteProduit1'] . '</td>';
                           echo '<td>' . fltPrixHT . '<td>';
                           echo '</tr>'k
                           echo '</table>';
                        }
                        else
                        {
                           // Soit c'est 0 soit on est au dessus de 100.
                        }
                     }
               }
            ?>
         </div>
         <?php include("footer.php");?>
