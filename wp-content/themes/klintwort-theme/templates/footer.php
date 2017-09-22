<div class="sep-30"></div>
<footer class="background-grey">
  <div class="container">
    <div class="sep-30"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="footer-brand"></div>
      </div>
    </div>
    <div class="sep-30"></div>
    <div class="row">
      <div class="sep-30"></div>
      <div class="col-lg-3 col-md-4 address">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Adressinformationen (Footer)')): ?>
        <?php endif;?>
      </div>
      <div class="col-lg-9 col-md-8 footer-menu">
        <div class="row">
          <div class="col-lg-3 col-md-4">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Social-Media')): ?>
            <?php endif;?>
          </div>
          <div class="col-lg-9 col-md-8">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Weitere Navigation im Footer')): ?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <div class="sep-30"></div>
  </div>
</footer>
