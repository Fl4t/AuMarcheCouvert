<?php include("../header.php");?>
               <li><a href="http://localhost:8888/AuMarcheCouvert/index.php">Accueil</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/commande.php">Nouvelle Commande</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/consultation.php">Consultation</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="http://localhost:8888/AuMarcheCouvert/ajout.php">Ajout</a></li>
               <li><a href="http://localhost:8888/AuMarcheCouvert/modification.php">Modification</a></li>
               <li class="actif"><a href="http://localhost:8888/AuMarcheCouvert/suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte-administration">
            <?php
               if ($_POST['suppression'] == "restaurant")
               {
               }
               elseif ($_POST['suppression'] == "produit")
               {
               }
               else
               {
                  echo '<p class="centrer">';
                  echo 'Suppression annulée.';
                  echo '<br />';
                  echo '<a href=../index.php>Retour à l\'index</a>';
                  echo '</p>';
               }
            ?>
         </div>
         <?php include("../footer.php");?>
