<?php
    use Roots\Sage\Setup;
    use Roots\Sage\Wrapper;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <?php
        do_action('get_header');
        get_template_part('templates/top-bar');
        get_template_part('templates/header');
    ?>
    <div id="main" class="container" role="document">
      <?php get_template_part('templates/page', 'header'); ?>
      <div class="row">
        <div class="col-md-12">
          <div class="main">
            <?php include Wrapper\template_path(); ?>
            <?php if (is_page_template('template-custom.php')): ?>
            <?php endif; ?>
            <?php if ( !( is_page('mitarbeiter-tipps') ) ) { ?>
              <?php if (Setup\display_sidebar()) : ?>
                <div class="col-lg-3 offset-lg-1 col-md-4 offset-md-1 col-sm-12">
                  <div class="sidebar">
                    <?php include Wrapper\sidebar_path(); ?>
                  </div>
                </div>
              <?php endif; ?>
            <?php } ?>
          </div>
        </div>
      </div>
      </div> 
    </div>  
    <?php
        do_action('get_footer');
        get_template_part('templates/footer');
        wp_footer();
    ?>
    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://use.fontawesome.com/6f05308ebc.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.4.14"></script>
    <script type="text/javascript" src="/wp-content/themes/klintwort-theme/base.js"></script>
  </body>
</html>