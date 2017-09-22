<?php while (have_posts()) : the_post(); ?>
<?php
	global $post;
	$postcat = get_the_category( $post->ID );
?>
  <?#php get_template_part('templates/page', 'header'); ?>
  <!-- <article <?#php post_class('pull-left'); ?>> -->
  <div class="row">
  <div class="col-lg-8 col-md-7 col-sm-12">
    <div class="row">
      <div class="col-md-12">
        <header style="margin-bottom: 0;">
          <?php
          if ( has_post_thumbnail() ) {
            the_post_thumbnail('full', ['class' => 'img-responsive responsive--full news_image', 'title' => 'Feature image']);
          } ?>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
        <?php echo is_category('8'); ?>
			  <?php if (in_category('8')) {
          echo '<a href="/angebote-aktionen/ihre-geschichte/" style="margin-top: 30px;" class="btn btn-default red">Zurück zu Ihre Geschichte</a>';
        } ?>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div>
              <h1>
                <?php if (in_category('8')) {
                  echo 'Weitere Geschichten';
                } else {
                  echo 'Weitere Gesundheitsnews';
                } ?>
              </h1>
            </div>
          </div>
        </div>
        <div class="row">
          <?php echo '<div class="col-md-12" style="margin-top: 30px;">'; ?>
            <?php if (in_category('8')) {
              echo do_shortcode( '[get_stories posts_per_page="4"]' );

            } 
            
            else {
              // echo do_shortcode( '[get_news_posts posts_per_page="4"]' );
              // Default arguments
              $args = array(
                'posts_per_page' => 4, // How many items to display
                'post__not_in'   => array( get_the_ID() ), // Exclude current post
                'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
              );

              // Check for current post category and add tax_query to the query arguments
              $cats = wp_get_post_terms( get_the_ID(), 'category' ); 
              $cats_ids = array();  
              foreach( $cats as $wpex_related_cat ) {
                $cats_ids[] = $wpex_related_cat->term_id; 
              }
              if ( ! empty( $cats_ids ) ) {
                $args['category__in'] = $cats_ids;
              }
              // Query posts
              $wpex_query = new wp_query( $args );
              // Loop through posts
              foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
                <div class="col-md-12 single-news" style="padding-left: 0;">
                  <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12">
                      <?php 
                      the_post_thumbnail('full', array( 'class' => 'news_image' ) );
                      ?>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-12 col-sm-12">
                      <div class="text">
                        <h2 style="margin-bottom: 15px; margin-top: 20px;"><?php the_title(); ?></h2> 
                        <p> <?php the_excerpt() . ' ...'; ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-default red">Weiterlesen</a>
                        <!-- </div> -->
                      </div>     
                    </div>           
                  </div>
                  <hr class="between_line">
                </div>
              <?php
              // End loop
              endforeach; 
            }
            // Reset post data
            wp_reset_postdata(); ?>
          <?php echo '</div>'; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- </article> -->
<?php endwhile; ?>