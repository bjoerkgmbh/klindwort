<article id="post-<?php the_ID();?>" <?php post_class($classes);?> >
  <h1 class="entry-title">
    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="url"><?php the_title(); ?></a>
  </h1>
  <span class="meta vcard" style="display:none;">
  <div class="postContent entry-content">
      <?php
      if($loopExcerpt == 0){
      the_content();
      }
      else{
          if ( has_post_thumbnail() ) {
            the_post_thumbnail('thumbnail', array('class' => 'alignleft'));
          }
      the_excerpt();
      echo '<div class="clearfix"></div>';
      }
      ?>
    <p class="postmetadata" style="display:none;" >Posted in
      <?php the_category(', '); ?>
      <br />
      <?php the_tags(); ?>
      <br />
      Source: <span class="vcard"><span class="source-org copyright">
      <?php bloginfo('name'); ?>
      </span></span>
    </p>
  </div>
</article>