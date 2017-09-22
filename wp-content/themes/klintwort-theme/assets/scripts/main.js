/* ###################################################################################
* DOM-based Routing
* Based on http://goo.gl/EUTi53 by Paul Irish
*
* Only fires on body classes that match. If a body class contains a dash,
* replace the dash with an underscore when adding it to the object below.
*
* .noConflict()
* The routing is enclosed within an anonymous function so that you can
* always reference jQuery with $, even when in .noConflict() mode.
* ======================================================================== */

(function($) {
  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'online-bestellung': {
      init: function() {
        // JavaScript to be fired on the bestellung page
      }
    }
  };
  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';
      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');
      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });
      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };
  // Load Events
  $(document).ready(UTIL.loadEvents);
})(jQuery); // Fully reference jQuery after this point.
/* ################################################################################### 
  This handels Top-Bar Mechanix
################################################################################### */
(function($) {
  $('.top-bar a').on('click', function(e) {
    e.preventDefault();
    myTarget = $(this).attr('class');
    $('#' + myTarget + '').stop(true, true).slideToggle('fast');
    $('#' + myTarget + '').siblings().slideUp('fast');
  });
  $('.top-bar-content--close').on('click', function() {
    $('#' + myTarget + '').slideUp('fast');
  });
})(jQuery);
/* ################################################################################### 
  I really dont like empty <p>'s
################################################################################### */
(function($) {
  $('p').each(function () {
    var $this = $(this);
    if ($this.html().replace(/\s|&nbsp;/g, '').length === 0 || $this.html().replace(/\s|<strong>&nbsp;<\/strong>/g, '').length === 0) {
      $this.remove();
    }
  });
})(jQuery);
/* ################################################################################### 
  This handels the Font-Size Changer
################################################################################### */
(function($) {
  $('.add-font-size span').on('click', function() {
    var new_font_size = $(this).attr('data-size');
    $('body').css('font-size', new_font_size+'px');
  });
})(jQuery);
/* ##################################################################################################### 
  This checks if there is an Image left or right to the .text Container and sets the Padding accordingly
###################################################################################################### */
(function($) {
  $('.text').each(function() {
    if ($(this).parent().next().find('img').length > 0) {
      $(this).css('padding-right', '0');
    }
  });
})(jQuery);
/* ################################################################################### 
  This sets the Height of the Facebook Inner container
####################################################################################### */
(function($) {
  $('.face-book-wrapper .text').css('height', '430px');
})(jQuery);
/* ################################################################################### 
  This adds a modal for gebührenpflicht question dialog
####################################################################################### */
(function($) {
   $('.radio-508 label').append('<div id="modaal-id-10" class="modalDialog"> <div> <div class="row"> <div class="col-md-12"> <h2>Gebührenbefreiung</h2> </div> </div> <div class="row"> <div class="col-md-12"> <p>Sie haben im Formular die Option »Gebührenbefreit« gewählt. Bitte bestätigen Sie, dass Sie von der gesetzlichen Zuzahlung auf Rezepte befreit und im Besitz eines gültigen Befreiungsausweises sind.</p> </div> </div> <div class="sep-30"></div> <div class="row"> <div class="col-md-12"> <a href="#close" title="Close" class="btn btn-default red pull-left close">Verstanden</a> </div> </div> </div> </div>');
    $('.close').on('click', function() {
      $('.modalDialog').css({
        'opacity':0,
        'pointer-events': 'none'
      });
    });
})(jQuery);
/* ################################################################################### 
  Add Row-Botton
####################################################################################### */
(function($) {
  var click_count = 1;
    $('.add-button').on('click', function(e) {
      e.preventDefault();
      target1 = $(this).parents().eq(3).prev();
      target2 = $(this).parents().eq(3);
      var clone = target1.clone();
      clone.insertBefore(target2);

      clone.find('input').each(function(){
        var old_name = $(this).attr('name');
        var old_name_clean = old_name.replace(/[0-9]/g, '');
        var new_name = $(this).attr('name', old_name_clean + click_count);
        $(this).removeAttr('value');
      });
      click_count++;
  });
})(jQuery);
/* ################################################################################### 
  Reset top menu href links.
####################################################################################### */
(function($) {
  var len = $('#menu-top-menu > li').length;
  $('#menu-top-menu > li').each(function(index) {
    if ((index !== 0) && (index !== (len - 1))) {
      $(this).children('a').attr("href", "#element");
    }
  });
  $("#menu-top-menu .sub-menu .location-hook").children('a').attr("href", "#element");
})(jQuery);
/* ################################################################################### 
  Shopproducts names shorting
####################################################################################### */
(function($) {
  $('.shopbox').each(function() {
    var text = $(this).find('.shopproductname').text().substr(0, 24);
    $(this).find('.shopproductname').html(text);
  });
})(jQuery);
/* ################################################################################### 
  Desktop and mobile navigation's function (normal - sticky - mobile)
####################################################################################### */
(function($) {
  $('.menu-item-object-locations a').each(function(){
    $(this).append('<div class="info">Info|Kontakt|Team</div>');
  });
  $('#menu-top-menu li .sub-menu .location-hook > a').each(function(){
    $(this).append('<i class="icon ion-ios-plus-empty"></i>');
  });
  $('#menu-top-menu .sub-menu .location-hook .sub-menu').hide();
  $(window).on("resize", function () {
    if ($( window ).width() >= 992) {

      $(window).scroll(function() {
        if ( $( window ).scrollTop() >= 250 ) {
          $('.nav-primary').addClass('sticky');
        } else {
          $('.nav-primary').removeClass('sticky');
        }
      });

      $('#menu-top-menu').children('li').off();
      $('#menu-top-menu').children('li').on('mouseenter', function() {
        $(this).children('.sub-menu').show('fast');
        $(this).siblings('li').children('.sub-menu').hide('fast');
      });
      $('#menu-top-menu').children('li').on('mouseleave', function() {
        $(this).children('.sub-menu').hide('fast');
      });
      $('#menu-top-menu .sub-menu .location-hook').off();
      $('#menu-top-menu .sub-menu .location-hook').on('click', function() {
        $(this).children('.sub-menu').slideToggle('fast'); 
        $(this).siblings('li').children('.sub-menu').slideUp('fast');
        $(this).children('a').find('.icon').toggleClass('ion-ios-plus-empty ion-ios-minus-empty');
        $(this).siblings('li').find('a > .icon').removeClass('ion-ios-minus-empty').addClass('ion-ios-plus-empty');
      });
    }
    else {
      $('#menu-top-menu').children('li').off();
      $('#menu-top-menu').children('li').on('click', function() {
        $(this).children('.sub-menu').slideToggle('fast');
        $(this).siblings('li').children('.sub-menu').slideUp('fast');
      });
      $('#menu-top-menu').find('.location-hook').off();
      $('#menu-top-menu').find('.location-hook').on('click', function(e) {
        e.stopPropagation();
        $(this).children('.sub-menu').slideToggle('fast');
        $(this).siblings('li').children('.sub-menu').slideUp('fast');
        $(this).children('a').find('.icon').toggleClass('ion-ios-plus-empty ion-ios-minus-empty');
        $(this).siblings('li').find('a > .icon').removeClass('ion-ios-minus-empty').addClass('ion-ios-plus-empty');
      });
    }
  }).resize();
})(jQuery);
/* ################################################################################### 
  Klindwort Facebook, access token for the posts
################################################################################### */
(function($) {
  var token = "EAAZANKULG1ZCMBAGHZCGNTABYR8XLuiUCjY9cQ9gRq3WeQL65NzyCmVKJD9QI11LAsbZAbFtdJc8zdAYcHblZB7ltNeWHg1c4VGTaDRyZCxmGMklrleJNmZAmE39raKF6xZBAS48PiaqArW6rW9jUB62wekNe4v7T929RfR2bNZBjpgZDZD";
  var user_id = '380274668658164';
  FB.api('/'+ user_id +'?fields=posts{from,message,full_picture}', function(response){
  $.each(response.posts.data, function(i, item) {
    $('#facebookPosts').empty();
    if (item.message === undefined) {
      item.message = '';
    }
    else {
      if (item.message.includes('>> ')) {
        var index = item.message.split('>> ');
        var message = index[0];
        var link = 'https://www.facebook.com/klindwortapotheken/';
        if (typeof item.full_picture === 'undefined') {
          item.full_picture = '/wp-content/uploads/facebook.jpg';
        }
        $('#facebookPosts').parent().append('<div class="row whitebg"><div class="col-xl-12 col-lg-5 col-md-5 col-sm-5"><a href="'+link+'" target="_blank"><img src="'+item.full_picture+'"></a></div><div class="col-xl-12 col-lg-7 col-md-7 col-sm-7"><h4>'+item.from.name+'</h4><p>'+message+' <a href="'+link+'" target="blank">(Weiterlesen)</a></p></div></div>');
      } else {
        if (typeof item.full_picture === 'undefined') {
          item.full_picture = '/wp-content/uploads/facebook.jpg';
        }
        var link_ = 'https://www.facebook.com/klindwortapotheken/';
        $('#facebookPosts').parent().append('<div class="row whitebg"><div class="col-xl-12 col-lg-5 col-md-5 col-sm-5"><a href="'+link_+'" target="_blank"><img src="'+item.full_picture+'"></a></div><div class="col-xl-12 col-lg-7 col-md-7 col-sm-7"><h4>'+item.from.name+'</h4><p>'+item.message+'</p></div></div>');
      }
    }
  });
  }, {access_token: token, limit: 5});
})(jQuery);
/* ################################################################################### 
  Accordion function for the Klindwort jobs
#################################################################################### */
(function($) {
  $('#accordion .card').each(function(i) {
    if (i !== 0) {
      $(this).find('a').addClass('collapsed');
    }
    if (i === 0 ) {
      $(this).find('#collapse0').addClass('show');
      $(this).find('a').attr('aria-expanded', 'true');
    }
  });
  $('#accordion .collapse').collapse({
    toggle: false
  });
})(jQuery);
/* ################################################################################### 
  Set fields placeholder for the form: (Geschichte einreichen)
####################################################################################### */
(function($) {
  $('.ap-pro-front-form-wrapper').find('.label-wrap').css('display', 'none');
  $('#ap-form-2 > div').each(function(i) {
    if (i === 0) {
      $(this).find('input[type="text"]').attr('placeholder', 'Ihr Name');
    }
    if (i === 1) {
      $(this).find('input[type="text"]').attr('placeholder', 'Ihr Wohnort');
    }
    if (i === 2) {
      $(this).find('input[type="text"]').attr('placeholder', 'Überschrift');
    }
    if (i === 3) {
      $(this).find('textarea').attr('placeholder', 'Ihre Geschichte');
    }
  });
})(jQuery);
/* ################################################################################### 
  Display button after succefull form submit in (Geschichte einreichen)
####################################################################################### */
(function($) {
  $('#goBack').css('display', 'none');
  $('#goBack').css('width', '340px');
  if($('.ap-pro-form-success-msg').css('display') === 'block') {
    $('#goBack').css('display', 'block');
  }
})(jQuery);
/* ################################################################################### 
  Make first child not selectable in some select fields 
####################################################################################### */
(function($) {
  $('.wpcf7-form-control-wrap.menu-495').children('select').children('option:first-child').attr('disabled', true);
  $('.wpcf7-form-control-wrap.menu-833').children('select').children('option:first-child').attr('disabled', true);
  $('.wpcf7-form-control-wrap.menu-832').children('select').children('option:first-child').attr('disabled', true);
})(jQuery);
/* ################################################################################### 
  Remove href links from breadcrumb
####################################################################################### */
(function($) {
  $('#breadcrumbs .item-cat').children('a').attr('href', '#');
})(jQuery);
/* ################################################################################### 
  Switch between headers in (Aktuelle Gesundheitsnews)
####################################################################################### */
(function($) {
  $('.col-lg-8.col-md-7.col-sm-12 > .row > .post_content').each(function() {
    $(this).children('h4').insertBefore($(this).children('h2'));
  });
})(jQuery);
/* ################################################################################### 
  Toggle between forms in (Online-Bestellung)
####################################################################################### */
(function($) {
  $('.rezept-frei').on('click', function(){
    $('#wpcf7-f223-p261-o2').parent().fadeOut();
    $('#wpcf7-f223-p80-o3').parent().fadeOut();
    $('.rezept').fadeOut('slow');
    $('#wpcf7-f220-p261-o1').fadeIn();
    $('.active').removeClass('active');
    $(this).toggleClass('active');
  });
  $('.rezept-pflicht').on('click', function(){
    $('.rezept').fadeIn('slow', function() {
      $('#wpcf7-f220-p261-o1').fadeOut('slow');
      $('#wpcf7-f223-p261-o2').parent().fadeIn();
      $('#wpcf7-f222-p261-o3').parent().fadeOut();
    });
    $('.active').removeClass('active');
    $('.rezept-pflicht-kasse').addClass('active');
    $('.form-manuell').addClass('active');
    $('.form-manuell').click(function(e){
      e.preventDefault();
    });
    $(this).toggleClass('active');
  });
  $('.rezept-pflicht-kasse').on('click', function(){
    $('#wpcf7-f223-p261-o2').parent().fadeIn('slow', function() {
      $('#wpcf7-f222-p261-o3').parent().fadeOut();
    });
    $('.rezept .active').removeClass('active');
    $(this).toggleClass('active');
  });
  $('.rezept-pflicht-privat').on('click', function(){
    $('#wpcf7-f223-p261-o2').parent().fadeOut('slow', function() {
      $('#wpcf7-f222-p261-o3').parent().fadeIn();
    });
    $('.rezept .active').removeClass('active');
    $('.active1').removeClass('active1');
    $(this).toggleClass('active');
  });
})(jQuery);
/* ################################################################################### 
  Reset styles when emergency search input is focused
####################################################################################### */
(function($) {
  $('#address').on('focusin', function() {
    $('#apotheken-notdienst').children('#all-informations').children().empty();
    if ( $('#all-informations').children().is(':empty') ) { 
      $('#apotheken-notdienst').children('#all-informations').css({
        'height':'0', 
        'margin':'0'
      });
      $('#apotheken-notdienst').children('#all-informations').children('#addresses').css({
        'height':'0'
      });
    }
  });
})(jQuery);
/* ################################################################################### 
  Select employee's standart work location
####################################################################################### */
(function($) {
  $('#employee').children('div').each(function() {
    $standort_id = $(this).children('div:last-child').children('h3').html();
    if ($standort_id === '197') {
      $(this).children('div:last-child').children('h3').html('Apotheke Lübecker Straße');
    }
    else if ($standort_id === '198') {
      $(this).children('div:last-child').children('h3').html('Apotheke Rathausgasse');
    }
    else if ($standort_id === '199') {
      $(this).children('div:last-child').children('h3').html('Apotheke Rathausgasse');
    }
    else if ($standort_id === '200') {
      $(this).children('div:last-child').children('h3').html('Apotheke am Strand');
    }
    else if ($standort_id === '201') {
      $(this).children('div:last-child').children('h3').html('Apotheke im LUV SHOPPING');
    }
  });
})(jQuery);
/* ################################################################################### 
  Set href link to online shop
####################################################################################### */
(function($) {
  $('#menu-top-menu').children('#menu-item-703').children('a').attr('href', 'https://shop.klindwort.de/category/Monatsangebote/c_65200.html');
  $('#menu-top-menu').children('#menu-item-703').children('a').attr('target', '_blank');
})(jQuery);
/* ################################################################################### 
  Pollenflugkalender hover effect
####################################################################################### */
(function($) {
  var cellIndex, tdColor, pollenType, text, month;
  $('#pollenflugkalender').on('mouseleave', '#calender-table', function() {
    $(this).parents('.row').children('.col-md-12:last-child').children('.hoverEffect').css('visibility', 'hidden');
  });
  $('#pollenflugkalender').on('hover', '#calender-table tbody tr td', function() {
    tdColor = $(this).css('background-color');
    pollenType = $(this).parent('tr').children('td:first-child').text();
    cellIndex = $(this).index();
    if ((cellIndex >= 1) && (cellIndex < 4)) { month = 'Dezimber';}
    else if ((cellIndex >= 4) && (cellIndex < 7)) { month = 'Januar';}
    else if ((cellIndex >= 7) && (cellIndex < 10)) { month = 'Februar';}
    else if ((cellIndex >= 10) && (cellIndex < 13)) { month = 'März';}
    else if ((cellIndex >= 13) && (cellIndex < 16)) { month = 'April';}
    else if ((cellIndex >= 16) && (cellIndex < 19)) { month = 'Mai';}
    else if ((cellIndex >= 19) && (cellIndex < 22)) { month = 'Juni';}
    else if ((cellIndex >= 22) && (cellIndex < 25)) { month = 'Juli';}
    else if ((cellIndex >= 25) && (cellIndex < 28)) { month = 'August';}
    else if ((cellIndex >= 28) && (cellIndex < 32)) { month = 'September';}
    else if ((cellIndex >= 32) && (cellIndex < 35)) { month = 'Oktober';}
    else if ((cellIndex >= 35) && (cellIndex < 38)) { month = 'November';}
    if ((tdColor === 'rgb(153, 255, 0)') || (tdColor === 'rgb(255, 153, 0)') || (tdColor === 'rgb(239, 11, 11)')) {
      $('#pollenflugkalender .row').children('.col-md-12:last-child').children('.hoverEffect').css('visibility', 'visible');
      $('#pollenflugkalender .row').children('.col-md-12:last-child').children('.hoverEffect').children('.fa').css('color', tdColor);
      $('#pollenflugkalender .row').children('.col-md-12:last-child').children('.hoverEffect').children('.type').text(function() {
        return 'Allergie: ' + pollenType + '. Flugsaison: ' + month + ' 2017.';
      });
    } else {
      $('#pollenflugkalender .row').children('.col-md-12:last-child').children('.hoverEffect').css('visibility', 'hidden');
    }
  });
})(jQuery);