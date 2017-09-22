<div id="<?php echo( basename(get_permalink()) );?>" class="hidden top-bar-section">
  <div class="sep-15"></div>
  <span class="top-bar-content--close"><h3>X Fenster schließen</h3></span>
  <h2><?php the_title(); ?></h2>
  <div class="sep-15"></div>
  <?php
  $content = apply_filters( 'the_content', get_the_content() );
  echo $content;
  ?>
</div>
