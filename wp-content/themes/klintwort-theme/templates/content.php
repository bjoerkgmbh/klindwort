<div class="col-md-12">
<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><?php the_title(); ?></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
  <a href="<?php the_permalink(); ?>" class="btn btn-default red">Weiterlesen</a>
  <hr class="between_line">
</article>
</div>