<?php
/**
* Template Name: Home Template
*/
?>
<div class="row">
  <div class="col-xl-8 col-lg-12 col-md-12">
    <div class="content-wrapper hero-unit">
      <div class="row single-news">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Aktuelle News')): ?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-12 col-md-12">
    <div class="content-wrapper red">
      <div class="row">
        <div class="col-md-12">
          <div class="text">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Aktuelle Aktionen')): ?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-5 col-lg-12 col-md-12">
    <div class="content-wrapper face-book-wrapper">
      <div class="text">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Facebook')): ?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div class="col-xl-7 col-lg-12 col-md-12">
    <div class="row">
      <div class="col-md-12">
        <div class="content-wrapper">
          <div class="row">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Videos')): ?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="content-wrapper">
          <div class="row">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Content Teaser')): ?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
<div id="mitarbeiterTippHome" class="col-xl-6 col-lg-12 col-md-12">
    <div class="content-wrapper">
      <div class="row">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Mitarbeiter-Tipps')): ?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div id="jobs_widget" class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    <div class="content-wrapper">
      <div class="text">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Jobs')): ?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <div id="ihre_meinung_widget" class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
    <div class="content-wrapper-right">
      <div class="text">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Jobs2')): ?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>