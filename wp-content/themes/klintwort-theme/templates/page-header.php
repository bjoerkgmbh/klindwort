<?php use Roots\Sage\Titles; ?>
<?php if (is_page_template('template-home.php')) {
  get_template_part('templates/header-slider');
}
?>
<?php get_template_part('templates/breadcrumb'); ?>
<?php if (!is_page_template('template-home.php')) {?>
  <div class="row">
    <div class="col-md-12">
      <?php $subline = get_post_meta( get_the_ID(), 'subline', true ); ?>
      <div class="page-header" style="margin-bottom: 40px; margin-top: 5px;">
        <?php if ($subline && !is_singular('locations')) {
          echo '<h3 class="subline">'.$subline.'</h3>';
        } ?>
        <h1 class="single-title"><?= Titles\title(); ?></h1>
      </div>
    </div>
  </div>
  <?php } ?>