<?php include("../header.php");?>
               <li><a href="http://localhost/bdd/index.php">Accueil</a></li>
               <li><a href="http://localhost/bdd/commande.php">Nouvelle commande</a></li>
               <li class="actif"><a href="http://localhost/bdd/consultation.php">Consultation</a></li>
               <li><a href="http://localhost/bdd/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li class="actif"><a href="http://localhost/bdd/traitement/traitement-ancien.php">Ancienne commande</a></li>
               <li><a href="http://localhost/bdd/traitement/traitement-mois.php">Recapitulatif mensuel</a></li>
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
            echo '<table><tr><td><label for="listeCommande">Choisissez une commande : </label></td>';
            echo '<td><select name="listeCommande" id="listeCommande">';
            // On crée une ligne vide pour qu'il n'y est rien par defaut.
            echo '<option value="Vide" selected="selected"></option>';
            $objCommandeDuRestaurant = $objBDD->prepare('SELECT NumCommande FROM Commandes INNER JOIN Restaurants ON Restaurants.CodeRestaurant = Commandes.CodeRestaurant WHERE NomRestaurant = :NomRestaurant ORDER BY NumCommande');
            $objCommandeDuRestaurant->execute(array('NomRestaurant' => stripslashes($_POST['listeRestaurants'])));
            while ($strCommandeDuRestaurant = $objCommandeDuRestaurant->fetch())
            {
                echo '<option value="' . htmlspecialchars($strCommandeDuRestaurant['NumCommande']) . '">' . htmlspecialchars($strCommandeDuRestaurant['NumCommande']) . '</option>';
            }
            $objCommandeDuRestaurant->closeCursor();
        }
        catch(Exception $e)
        {
            die('Erreur objCommandeDuRestaurant : ' . $e->getMessage());
        }
        echo '</td></tr></table></select>';
        echo '<p class="centrer"><input type="submit" value="Continuer" /></p>';
        echo '</form>';
    }
    else
    {
        echo '<p class="centrer">';
        echo 'Vous devez séléctionner un restaurant.';
        echo '<br />';
        echo '<a href=traitement-ancien.php>Retour aux anciennes commandes.</a>';
        echo '</p>';
    }
}
elseif (isset($_POST['listeCommande']))
{
    if ($_POST['listeCommande'] != "Vide")
    {
        echo '<h3><strong>' . htmlspecialchars($_SESSION['NomRestaurant']) . '</strong></h3>';
        // J'en ai pas besoin plus longtemps.
        session_destroy();
        echo '<table><thead><tr>';
        echo '<td class="recapitulatif">Produits :</td>';
        echo '<td class="recapitulatif">Quantité :</td>';
        echo '<td class="recapitulatif">Prix du jour :</td>';
        echo '<td class="recapitulatif">Prix HT :</td>';
        echo '</tr></thead><tbody>';
        try
        {
            // On affiche la commande via une requête SQL.
            $objContenirCommande = $objBDD->prepare('SELECT DesignProduit, QteCommande, PrixDuJour, QteCommande * PrixDuJour AS Total FROM Produits INNER JOIN Contenir ON Produits.RefProduit = Contenir.RefProduit WHERE NumCommande=:intNumCommande');
            $objContenirCommande->execute(array('intNumCommande' => $_POST['listeCommande']));
            while ($strContenirCommande=$objContenirCommande->fetch())
            {
                echo '<tr>';
                echo '<td class="recapitulatif">' . $strContenirCommande['DesignProduit'] . '</td>';
                echo '<td class="recapitulatif">' . $strContenirCommande['QteCommande'] . '</td>';
                echo '<td class="recapitulatif">' . $strContenirCommande['PrixDuJour'].' €</td>';
                echo '<td class="recapitulatif">' . $strContenirCommande['Total'] . ' €</td>';
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
            echo '<td class="centrer">' . $strPrixCommande['TotalCommande'] . ' €</td>';
            echo '</tr></tbody></table>';
        }
        catch(Exception $e)
        {
            die('Erreur strPrixCommande : ' . $e->getMessage());
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
    echo '';
    echo '<table><tr><td><label for="listeRestaurants">Choisissez un restaurant : </label></td>';
    echo '<td><select name="listeRestaurants" id="listeRestaurants">';
    // On crée une ligne vide pour qu'il n'y est rien par defaut.
    echo '<option value="Vide" selected="selected"></option>';
    try
    {
        // On récupère les noms des objRestaurants, sinon il y aura une erreur explicite.
        $objNomRestaurants = $objBDD->query('SELECT NomRestaurant FROM Restaurants ORDER BY NomRestaurant');
        // On affiche les noms des objRestaurants dans une liste déroulante.
        while ($strNomRestaurants = $objNomRestaurants->fetch())
        {
            echo '<option value="' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '">' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '</option>';
        }
        $objNomRestaurants->closeCursor(); // Termine le traitement de la requête
    }
    catch (Exception $e)
    {
        die('Erreur strNomRestaurants :' . $e->getMessage());
    }
    echo '</td></tr></table>';
    echo '</select>';
    echo '<p class="centrer"><input type="submit" value="Continuer" /></p>';
    echo '</form>';
}
?>
         </div>
         <?php include("../footer.php");?>
