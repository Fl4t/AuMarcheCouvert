<?php include("../header.php");?>
               <li><a href="http://localhost:8888/AuMarcheCouvert/index.php">Accueil</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/commande.php">Nouvelle Commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/consultation.php">Consultation</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/traitement/traitement-ancien.php">Ancienne commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/"></a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/"></a></li>
            </ul>
         </div>
         <div id="texte">
            <!-- Je l'apelle lui-même à chaque étape du traitement. -->
               <?php
                  //
                  // Deuxième étape : On séléctionne une commande.
                  //
                  if (isset($_POST['listeRestaurants']))
                  {
                     if ($_POST['listeRestaurants'] != "Vide")
                     {
                     $_SESSION['NomRestaurant'] = stripslashes($_POST['listeRestaurants']);
                        try
                        {
                           echo '<form method="POST" action="traitement-ancien.php">';
                           echo '<p><label for="listeCommande">Choisissez une commande : </label>';
                           echo '<select name="listeCommande" id="listeCommande">';
                           // On crée une ligne vide pour qu'il n'y est rien par defaut.
                           echo '<option value="Vide" selected="selected"></option>';
                           $objCommandeDuRestaurant = $objBDD->prepare('SELECT NumCommande FROM Commandes INNER JOIN Restaurants ON Restaurants.CodeRestaurant = Commandes.CodeRestaurant WHERE NomRestaurant = :NomRestaurant ORDER BY NumCommande');
                           $objCommandeDuRestaurant->execute(array('NomRestaurant' => stripslashes($_POST['listeRestaurants'])));
                           while ($strCommandeDuRestaurant = $objCommandeDuRestaurant->fetch())
                           {
                              echo '<option value="'.htmlspecialchars($strCommandeDuRestaurant['NumCommande']).'">'.htmlspecialchars($strCommandeDuRestaurant['NumCommande']).'</option>';
                           }
                           $objCommandeDuRestaurant->closeCursor(); 
                           echo '</select><br />';
                           echo '<input type="submit" value="Continuer" /></p>';
                           echo '</form>';
                        }
                        catch(Exception $e)
                        {
                           die('Erreur P_CommandeDuRestaurant : ' . $e->getMessage());
                        }
                     }
                     else
                     {
                        echo '<p class="centrer">';
                        echo 'Vous devez séléctionner un restaurant.';
                        echo '<br />';
                        echo '<a href=../index.php>Retour à l\'index</a>';
                        echo '</p>';
                     }
                  }
                  elseif (isset($_POST['listeCommande']))
                  {
                     if ($_POST['listeCommande'] != "Vide")
                     {
                        echo '<h3><strong>'.htmlspecialchars($_SESSION['NomRestaurant']).'</strong></h3>';
                        // J'en ai pas besoin plus longtemps.
                        session_destroy();
                        echo '<table>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<td class="recapitulatif">Produits :</td>';
                        echo '<td class="recapitulatif">Quantité :</td>';
                        echo '<td class="recapitulatif">Prix du jour :</td>';
                        echo '<td class="recapitulatif">Prix HT :</td>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        try
                        {
                           // On affiche la commande via une requête SQL.
                           $objContenirCommande = $objBDD->prepare('SELECT DesignProduit, QteCommande, PrixDuJour, QteCommande * PrixDuJour AS Total FROM Produits INNER JOIN Contenir ON Produits.RefProduit = Contenir.RefProduit WHERE NumCommande=:intNumCommande');
                           $objContenirCommande->execute(array('intNumCommande' => $_POST['listeCommande']));
                           while ($strContenirCommande=$objContenirCommande->fetch())
                           {
                              echo '<tr>';
                              echo '<td class="recapitulatif">'.$strContenirCommande['DesignProduit'].'</td>';
                              echo '<td class="recapitulatif">'.$strContenirCommande['QteCommande'].'</td>';
                              echo '<td class="recapitulatif">'.$strContenirCommande['PrixDuJour'].' €</td>';
                              echo '<td class="recapitulatif">'.$strContenirCommande['Total'].' €</td>';
                              echo '</tr>';
                           }
                           $objContenirCommande->closeCursor();
                           // On fait le Total de la commande dans une autre (pas reussi autrement)
                           $objPrixCommande = $objBDD->prepare('SELECT SUM(QteCommande * PrixDuJour) AS TotalCommande FROM Produits INNER JOIN Contenir ON Produits.RefProduit = Contenir.RefProduit WHERE NumCommande=:intNumCommande');
                           $objPrixCommande->execute(array('intNumCommande' => $_POST['listeCommande']));
                           $strPrixCommande=$objPrixCommande->fetch();
                           $objPrixCommande->closeCursor();
                           echo '<tr>'; // on affiche le prix total HT.
                           echo '<td></td>';
                           echo '<td></td>';
                           echo '<td class="centrer"><b>Prix Total :</b></td>';
                           echo '<td class="centrer">'.$strPrixCommande['TotalCommande'].' €</td>';
                           echo '</tr>';
                           echo '</tbody>';
                           echo '</table>';
                        }
                        catch(Exception $e)
                        {
                           die('Erreur : ' . $e->getMessage());
                        }
                     } 
                     else
                     {
                        echo '<p class="centrer">';
                        echo 'Vous devez séléctionner une commande.';
                        echo '<br />';
                        echo '<a href=../index.php>Retour à l\'index</a>';
                        echo '</p>';
                     }
                  }
                  else
                  {
                     //
                     // Première étape : On séléctionne un restaurant.
                     //
                     echo '<form method="POST" action="traitement-ancien.php">';
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
                     echo '</form>';
                  }
               ?>
         </div>
         <?php include("../footer.php");?>
