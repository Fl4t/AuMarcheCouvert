<?php include("header.php");?>
               <li><a href="index.php">Accueil</a></li>
               <li><a href="commande.php">Nouvelle commande</a></li>
               <li class="actif"><a href="consultation.php">Consultation</a></li>
               <li><a href="administration.php">Administration</a></li>
            </ul>
         </nav>
         <div id="panneau">
            <ul>
               <li><a href="traitement/traitement-ancien.php">Ancienne commande</a></li>
               <li><a href="traitement/traitement-mois.php">Recapitulatif mensuel</a></li>
            </ul>
         </div>
         <div id="texte">
            <blockquote>
               <h2>Ancienne commande</h2>
               <p>
                  <strong>Ancienne commande</strong> permet d'analyser les commandes précédemment passé. 
               </p>
               <h2>Recapitulatif mensuel</h2>
               <p>
                  <strong>Recapitulatif mensuel</strong> affiche le nombre de commande passée par un restaurant ainsi que leurs montants, le montant de toutes les commandes est aussi renseigné.
               </p>
            </blockquote>
         </div>
         <?php include("footer.php");?>
