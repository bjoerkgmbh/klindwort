<?#php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<div class="row">
  <div class="col-lg-8 col-md-7 col-sm-12">
    <div class="col-md-12" style="padding: 0; margin-bottom: 50px;">
      <p style="margin-bottom: 15px;">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam.</p>
      <a class="btn btn-default red" href="http://dev.klindwort-apotheken.de/angebote-aktionen/ihre-geschichte/einreichen">Erzählen Sie Ihre Geschichte</a>
      <hr class="between_line" />
    </div>
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
  <?php endwhile; ?>
  <div style="position: absolute; bottom: 0; left: 0;">
    <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts', 0 ); ?></div>
    <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts', 0 ); ?></div>
  </div>

</div>

<?#php the_posts_navigation(); ?>
