<?php while (have_posts()) : the_post(); ?>
  <?php
  $place_id = get_post_meta( get_the_ID(), 'place_id', true );
  $opening_hours = '';
  $json = loadFile('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$place_id.'&key=AIzaSyCGe4zzblB8biqGd0qAWW4t7bC2QA9O0Kw&language=de');
  $data = json_decode($json);
  if ($data) {
    $json_data = $data->{'result'};
    $opening_hours = $json_data->opening_hours->weekday_text;
  }

  ?>
  <?#php get_template_part('templates/page', 'header'); ?>
  <div <?php post_class('row'); ?>>
    <div class="col-md-12">
      <div class="box-shadow">
        <div class="row">
          <div class="col-xl-8 col-lg-12 col-md-12 filiale-image">
            <?php
            if ( has_post_thumbnail() ) {
              the_post_thumbnail('featured-image', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']);
            } else {
              echo '<img src="https://placeholdit.imgix.net/~text?txtsize=16&txt=noch+kein+Bild&w=1110&h=500" class="img-responsive">';
            } ?>
          </div>
          <div class="col-xl-4 col-lg-12 col-md-12 filiale">
            <?php the_content(); ?>

            <div id="ajax-panel">
              <?php
              if ($opening_hours) {
                foreach ($opening_hours as $key => $opening_hour) {
                  echo '<div class="ommo">'.$opening_hours[$key].'</div>';
                }
              } else {
                echo 'Noch keine Zeiten eingetragen.';
              }
              ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php $contact_form = get_post_meta( get_the_ID(), 'contactform_id', true ); ?>
  <div class="row">
    <div class="col-md-12">
      <h1 id="filialen_kontakt" class="sub-headline">Kontakt</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <?php echo do_shortcode( '[contact-form-7 id="'.$contact_form.'"]' ); ?>
    </div>
  </div>
  <?php $subline = get_post_meta( get_the_ID(), 'subline', true ); ?>
  <div class="row">
    <div id="filialen_willkommen_nachricht" class="col-md-12">
      <h3><?php echo $subline; ?></h3>
      <h1>Wir freuen uns auf Ihren Besuch!</h1>
    </div>
  </div>
  <?php
  $the_post_id = get_the_ID();
  echo do_shortcode( '[get_team posts_per_page="8" class="team-container" standort="'.$the_post_id.'"]' );
  ?>

<?php endwhile; ?>
