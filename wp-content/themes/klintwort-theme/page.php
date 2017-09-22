<?php while (have_posts()) : the_post(); ?>
  <?#php get_template_part('templates/page', 'header'); ?>
  <?#php get_template_part('templates/content', 'page'); ?>
  <div class="row">
    <!-- <div class="col-md-12"> -->
      <div class="col-lg-8 col-md-7 col-sm-12">
         <!-- <div style="float: left; padding-left: 0; padding-right: 80px;">  -->
         <?php get_template_part('templates/content', 'page'); ?>
      </div>
<?php endwhile; ?>
