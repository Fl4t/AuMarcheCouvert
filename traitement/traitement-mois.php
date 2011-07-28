<?php include("../header.php");?>
               <li><a href="http://localhost/bdd/index.php">Accueil</a></li>
               <li><a href="http://localhost/bdd/commande.php">Nouvelle commande</a></li>
               <li class="actif"><a href="http://localhost/bdd/consultation.php">Consultation</a></li>
               <li><a href="http://localhost/bdd/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="http://localhost/bdd/traitement/traitement-ancien.php">Ancienne commande</a></li>
               <li class="actif"><a href="http://localhost/bdd/traitement/traitement-mois.php">Recapitulatif mensuel</a></li>
            </ul>
         </div>
         <div id="texte">
            <!-- Je l'apelle lui-même à chaque étape du traitement. -->
<?php
//
// Deuxième étape : On affiche les commandes du restaurant
//
if (isset($_POST['listeRestaurants']))
{
    if ($_POST['listeRestaurants'] != "Vide" && $_POST['listeMois'] !="Vide" && $_POST['listeAnnee'] !="Vide")
    {
        echo '<h3><strong>'.htmlspecialchars($_SESSION['NomRestaurant']).'</strong></h3>';
        // J'en ai pas besoin plus longtemps.
        session_destroy();
        echo '<table><thead>';
        echo '<tr>';
        echo '<td class="recapitulatif">N° de commande :</td>';
        echo '<td class="recapitulatif">Prix Total :</td>';
        echo '</tr>';
        echo '<tbody></thead>';
        try
        {
            // On récupère la liste des commandes ainsi que le prix total de la commande en fonction du restaurants, du mois
            // et de l'année renseigné, on affiche tout ça proprement dans un tableau.
            $objCommandeDuRestaurant = $objBDD->prepare('SELECT Commandes.NumCommande AS Num_Commande, SUM( QteCommande * PrixDuJour ) AS TotalCom FROM Commandes INNER JOIN Restaurants ON Commandes.CodeRestaurant = Restaurants.CodeRestaurant INNER JOIN Contenir ON Commandes.NumCommande = Contenir.NumCommande WHERE NomRestaurant = :NomRestaurant AND MONTH( DateCommande ) = :MoisCommande AND YEAR( DateCommande ) = :AnneeCommande GROUP BY Num_Commande');
            $objCommandeDuRestaurant->execute(array(
                'NomRestaurant' => stripslashes($_POST['listeRestaurants']),
                'MoisCommande' => $_POST['listeMois'],
                'AnneeCommande' => $_POST['listeAnnee']));
            while ($strCommandeDuRestaurant=$objCommandeDuRestaurant->fetch())
            {
                echo '<tr>';
                echo '<td class="recapitulatif">' . $strCommandeDuRestaurant['Num_Commande'] . '</td>';
                echo '<td class="recapitulatif">' . $strCommandeDuRestaurant['TotalCom'] . ' €</td>';
                echo '</tr>';
            }
            $objCommandeDuRestaurant->closeCursor();
        }
        catch(Exception $e)
        {
            die('Erreur strCommandeDuRestaurant : ' . $e->getMessage());
        }
        try
        {
            // On récupère la somme de toutes les commandes du restaurant pour un mois et une année donnée.
            $objTotalCommandeMois= $objBDD->prepare('SELECT SUM( QteCommande * PrixDuJour ) AS TotalComMois FROM Commandes INNER JOIN Restaurants ON Commandes.CodeRestaurant = Restaurants.CodeRestaurant INNER JOIN Contenir ON Commandes.NumCommande = Contenir.NumCommande WHERE NomRestaurant = :NomRestaurant AND MONTH( DateCommande ) = :MoisCommande AND YEAR( DateCommande ) = :AnneeCommande');
            $objTotalCommandeMois->execute(array(
                'NomRestaurant' => stripslashes($_POST['listeRestaurants']),
                'MoisCommande' => $_POST['listeMois'],
                'AnneeCommande' => $_POST['listeAnnee']));
            $strTotalCommandeMois=$objTotalCommandeMois->fetch();
            $objTotalCommandeMois->closeCursor();
            echo '<tr>'; // on affiche le prix total HT.
            echo '<td class="centrer"><b>Somme  :</b></td>';
            echo '<td class="centrer">' . $strTotalCommandeMois['TotalComMois'] . ' €</td>';
            echo '</tr>';
            echo '</tbody></table>';
        }
        catch(Exception $e)
        {
            die('Erreur strTotalCommandeMois : ' . $e->getMessage());
        }
    }
    else
    {
        echo '<p class="centrer">';
        echo 'Vous devez séléctionner un restaurant, une année et un mois.';
        echo '<br />';
        echo '<a href=traitement-mois.php>Retour au recapitulatif</a>';
        echo '</p>';
    }
}
else
{
    //
    // Première étape : On séléctionne un restaurant, un mois et une année
    //
    echo '<form method="POST" action="traitement-mois.php">';
    echo '<table><tr>';
    echo '<td><label for="listeRestaurants">Choisissez un restaurant : </label></td>';
    echo '<td><select name="listeRestaurants" id="listeRestaurants">';
    echo '<option value="Vide" selected="selected"></option>';
    // On affiche les restaurants dans une liste déroulante
    try
    {
        $objNomRestaurants = $objBDD->query('SELECT NomRestaurant FROM Restaurants ORDER BY NomRestaurant');
        // On affiche les noms des objRestaurants dans une liste déroulante.
        while ($strNomRestaurants = $objNomRestaurants->fetch())
        {
            echo '<option value="' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '">' . htmlspecialchars($strNomRestaurants['NomRestaurant']) . '</option>';
        }
        $objNomRestaurants->closeCursor(); // Termine le traitement de la requête
    }
    Catch (Exception $e)
    {
        die('Erreur strNomRestaurants : ' . $e->getMessage());
    }
    echo '</td></tr>';
    //
    // On affiche les mois dans une liste déroulante
    //
    echo '<tr><td></select><label for="listeMois">Choisissez un mois : </label></td>';
    echo '<td><select name="listeMois" id="listeMois">';
    echo '<option value="Vide" selected="selected"></option>';
    for ($intMois=1;$intMois<=12;$intMois++)
    {
        echo '<option value="' . $intMois . '">' . $intMois . '</option>';
    }
    //
    // On affiche les années dans une liste déroulante
    //
    echo '</select></td></tr>';
    echo '<tr><td><label for="listeAnnee">Choisissez une année : </label></td>';
    echo '<td><select name="listeAnnee" id="listeAnnee">';
    echo '<option value="Vide" selected="selected"></option>';
    for ($intAnnee=2000;$intAnnee<=2020;$intAnnee++)
    {
        echo '<option value="' . $intAnnee . '">' . $intAnnee . '</option>';
    }
    echo '</select></td></tr></table>';
    echo '<p class="centrer"><input type="submit" value="Continuer" /></p>';
    echo '</form>';
}
?>
         </div>
         <?php include("../footer.php");?>
