<div class="row">
  <div class="col-md-12 slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        
        <div class="carousel-inner" role="listbox">
          <?php
          $gallery_ids = rwmb_meta( 'slider_gallery' );
          $image_counter = 1;
          if ( $gallery_ids ) {
            foreach ( $gallery_ids as $gallery_id ) {

              echo '<div class="carousel-item">';
                $image = $gallery_id;
                if (isset($image['post_title'])) {
                  $image_title = $image['post_title'];
                }
                if (isset($image['caption'])) {
                  $image_caption = $image['caption'];
                }
                $image_id = $image['ID'];
                $image_link = get_post_meta( $image_id, '_advert_link', true );
                $thumbimg = wp_get_attachment_url( $gallery_id['ID'], $size = 'full', false );
                echo '<img class="d-block img-fluid" src="'.$thumbimg.'" alt="First slide">';
                echo '<a class="link" href="'.$image_link.'">';
                echo '<span>'.$image_caption.'</span>';
                echo'</a>';
              echo '</div>';
            }
          }
          ?>
        </div>
        <ol class="carousel-indicators">
          <?php
          $gallery_ids = rwmb_meta( 'slider_gallery' );
          $counter = 0;
          if ( $gallery_ids ) {
            foreach ( $gallery_ids as $gallery_id ) {
              if ($counter == 0) {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $counter . '" class="active"></li>';
              }
              else {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $counter . '"></li>';
              }
              $counter++;
            }
          }
          ?> 
        </ol>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
  </div>
</div>
