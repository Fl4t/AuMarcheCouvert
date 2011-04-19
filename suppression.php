<?php include("header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li><a href="commande.php">Nouvelle commande</a></li>
               <li><a href="consultation.php">Consultation</a></li>
               <li class="actif"><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="ajout.php">Ajout</a></li>
               <li><a href="modification.php">Modification</a></li>
               <li class="actif"><a href="suppression.php">Suppression</a></li>
            </ul>
         </div>
         <div id="question">
               <form method="post" action="traitement/traitement-suppression.php">
                  <p>
                     Que voulez-vous supprimer ?
                     <br /><br />
                     <input type="radio" name="suppression" value="restaurant" id="restaurant" /><label for="restaurant">un restaurant</label><br />
                     <input type="radio" name="suppression" value="produit" id="produit" /><label for="produit">un produit</label>
                     <br /><br />
                     <input type="submit" value="Continuer" />
                  </p>
               </form>
         </div>
         <?php include("footer.php");?>
