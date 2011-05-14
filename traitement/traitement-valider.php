<?php include("../header.php");?>
               <li><a href="http://localhost:8888/AuMarcheCouvert/index.php">Accueil</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/commande.php">Nouvelle Commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/consultation.php">Consultation</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="texte">
            <?php
               // affichage pour savoir si c'est fait.
               echo '<pre>';
               print_r($_SESSION);
               echo '</pre>';

               if ($_POST['valider'] == "Oui")
               {
                  // Appel de la fonction F_CodeDuRestaurant
                  // stripslashes au cas ou un restaurant est un appostrophe.
                  $intCodeRestaurant = F_CodeDuRestaurant(stripslashes($_SESSION['NomRestaurant']));
                  P_CreationCommande($intCodeRestaurant); // Appel de la fonction de création de la commande.
                  $intDerniereID = (integer) $objBDD->lastInsertId(); // On récupère la valeur de la dernière insertion id (string) car comme c'est en auto-increment, on ne connaissai pas la valeur.
                  for($intNombreDeProduits=1;$intNombreDeProduits <= $_SESSION['NombreDeProduits'];$intNombreDeProduits++)
                  {
                     // Pour que ça soit plus clair, j'affecte dabord dans une variable avant de placer en parametre.
                     // stripslashes au cas ou un produit est un appostrophe.
                     $intRefProduit = F_RefDuProduit(stripslashes($_SESSION['Panier']['DesignProduit'][$intNombreDeProduits]));
                     $fltQteCommande = $_SESSION['Panier']['QuantiteProduit'][$intNombreDeProduits];
                     $fltPrixDuJour = $_SESSION['Panier']['PrixDuJour'][$intNombreDeProduits];
                     P_AjoutDesProduits($intRefProduit,$intDerniereID,$fltQteCommande,$fltPrixDuJour); // Appel de la fonction P_AjoutDesProduits.
                  }
                  echo '<p class="centrer">';
                  echo 'Commande ajoutée !';
                  echo '<br />';
                  echo '<a href=../index.php>Retour à l\'index</a>';
                  echo '</p>';
                  // Détruit la variable SESSION puisque l'on à fini !
                  session_destroy();
               }
               else
               {
                  echo '<p class="centrer">';
                  echo 'Commande annulée.';
                  echo '<br />';
                  echo '<a href=../commande.php>Retour aux commandes</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
