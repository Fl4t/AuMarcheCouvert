<?php include("header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li><a href="commande.php">Nouvelle Commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li class="actif"><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="ajout.php">Ajout</a></li>
               <li><a href="modification.php">Modification</a></li>
               <li><a href="suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="texte">
            <blockquote>
               <h2>Ajout</h2>
               <p>
                  <strong>Ajout</strong> permet d'entrer de nouveaux produits et restaurants. 
               </p>
               <h2>Modification</h2> 
               <p>
                  <strong>Modification</strong> permet d'actualiser des données sur des restaurants ou produits existants.
               </p>
               <h2>Suppression</h2> 
               <p>
                  <strong>Suppression</strong> permet de retirer des produits qui ne sont plus utilisées ou un restaurant.
               </p>
            </blockquote>
         </div>
         <?php include("footer.php");?>
