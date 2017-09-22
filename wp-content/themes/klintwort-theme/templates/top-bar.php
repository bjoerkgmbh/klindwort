<div class="top-bar hidden-md-down">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php
        $topbar = new WP_Query(
          array(
            'post_type' => 'topbar',
            'posts_per_page' => -1,
            'orderby' => 'menu_position',
            'post_status' => 'publish',
          )
        );
        ?>

        <?php if($topbar->have_posts()) : ?>
          <?php while($topbar->have_posts()) : $topbar->the_post(); ?>
            <a href="#<?php echo( basename(get_permalink()) );?>" class="<?php echo( basename(get_permalink()) );?>"><?php the_title(); ?></a>
          <?php endwhile; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php
$topbar = new WP_Query(
  array(
    'post_type' => 'topbar',
    'posts_per_page' => -1,
    'orderby' => 'menu_position',
    'post_status' => 'publish',
  )
);
?>

<div class="top-bar-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php if($topbar->have_posts()) : ?>
          <?php while($topbar->have_posts()) : $topbar->the_post(); ?>
            <?php get_template_part('templates/content-single-topbar');?>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php wp_reset_query();  ?>