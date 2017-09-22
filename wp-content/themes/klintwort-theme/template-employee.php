<?php
/**
* Template Name: Employee Template
*/
?>
<?php while (have_posts()) : the_post(); ?>
  <div class="row">
    <div id="employee" class="col-md-12">
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
  <!-- </div> -->
<?php endwhile; ?>
