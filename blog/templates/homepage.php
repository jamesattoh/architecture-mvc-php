<?php $title = "Le Blog de l'AVBN" ;?> <!--we attribute this title to the variable according to layout.php code -->

<?php ob_start(); ?> <!-- this function enters in memory all the html code which is next-->
   <h1>Le super blog de l'AVBN !</h1>
   <p>Derniers billets du blog :</p>

   <?php 
   foreach($posts as $post) {
   ?>

   <div class="news">
      <h3>
         <?= htmlspecialchars($post['title']); ?> <!-- the use of "short open tags" or "short eco tags" syntax -->
         <em>le <?= $post['french_creation_date']; ?></em>
      </h3>
         <p>
         <?= nl2br(htmlspecialchars($post['content'])); ?> <!-- // we display the post content  -->
         <br/>
         <em><a href="index.php?action=post&id=<?= urlencode($post['identifier']) ?>">Commentaires</a></em> <!-- urlencode is to encode a string (character string) in url && index.php?action=post&id= because now iit's our rooter which manage the ids -->
         </p>
   </div>
   <?php
   }// tthe end of the posts loop
   ?>

<?php $content = ob_get_clean(); ?> <!--with this line, we retrieve all the content generated in the variable $content -->

<?php require('templates/layout.php') ?> <!--VERY IMPORTANT !! we display the layout page filled with the components completed above-->