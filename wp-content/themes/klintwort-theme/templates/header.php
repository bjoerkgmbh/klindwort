<div id="for_print_layout" class="row" style="display: none;">
  <div class="col-md-12">
    <img src="/wp-content/uploads/logo-klindwort.svg" alt="logo">
  </div>
</div>
<header class="banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="row above-top-nav">
          <div class="col-md-12 hidden-lg-up">
            <button 
              class="c-hamburger c-hamburger--rot" 
              style="position: absolute; right: 15px; top: 0; font-size: 3rem; z-index: 9999;"
              onClick="displayBurgerMenu()">
              <span>toggle menu</span>
            </button>
          </div>
          <div class="col-lg-4 col-md-5">
            <a class="brand above" href="<?= esc_url(home_url('/')); ?>"></a>
          </div>
          <div class="col-lg-8 col-md-7">
              <div class="tel-holder above">
                <a href="#" style="cursor: default;">
                  <img src="/wp-content/uploads/phone-call.svg" alt="">
                  <p>0451 29 25 011</p>
                </a>
              </div>
              <div class="mail-holder above">
                <a href="mailto:info@klindwort.de" target="_blank">
                  <img src="/wp-content/uploads/e-mail-envelope.svg" alt="">
                  <p>info@klindwort.de</p>
                </a>
              </div>
              <div class="face-holder above">
                <a href="https://www.facebook.com/klindwortapotheken/" target="_blank">
                  <img src="/wp-content/uploads/facebook.svg" alt="">
                  <p>Facebook</p>
                </a>
              </div>
              <div class="search above">
                <?php get_search_form(); ?>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sep-30 under-logo"></div>
    <div class="row">
      <div class="col-md-12">
        <nav id="mySidenav" class="nav-primary sidenav">
          <div class="row">
            <div class="col-md-12">
              <?php
                if (has_nav_menu('primary_navigation')) :
                  wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
                endif;
                ?>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>
