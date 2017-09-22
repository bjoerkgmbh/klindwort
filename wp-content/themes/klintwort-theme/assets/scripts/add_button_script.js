/* ======================================================================== 
  
=========================================================================== */
(function($) {
  function addGPlacesButtonTOAdmin() {
    $('#place_id').parent().append('<input type="button" id="get_g_places_id" class="ed_button button button-small" title="Open Google Places" value="Get Places ID">');
    $('#get_g_places_id').on('click', function(e) {
      e.preventDefault();
      window.open("https://developers.google.com/places/place-id?hl=de", "myWindow", 'width=800,height=600');
      window.close();
    });
  }
  setTimeout(function() {
    addGPlacesButtonTOAdmin();
  }, 1000);
})(jQuery); // Fully reference jQuery after this point.