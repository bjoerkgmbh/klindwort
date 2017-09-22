<?php

define('WP_USE_THEMES', false);
require('../../../../wp-config.php');

if (!empty(htmlspecialchars($_POST['apo_date']))) {
  $ap_date = htmlspecialchars($_POST['apo_date']);
}
if (!empty(htmlspecialchars($_POST['apo_adress_latitude']))) {
  $apo_adress_latitude = htmlspecialchars($_POST['apo_adress_latitude']);
}
if (!empty(htmlspecialchars($_POST['apo_adress_longitude']))) {
  $apo_adress_longitude = htmlspecialchars($_POST['apo_adress_longitude']);
}

// echo $ap_date;
// echo $apo_adress_latitude;
// echo $apo_adress_longitude;

$result = '';

//$json = file_get_contents('https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=utf8&m=ort&w=364');
//$json = file_get_contents('https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=utf8&m=ort&w=297');
//$json = file_get_contents("https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=iso&m=koord&w=$apo_adress_latitude;$apo_adress_longitude&z=$ap_date&a=4");
$json = loadFile("https://www.aksh-notdienst.de/notdienste/exporte/ndk.php?f=json&c=iso&m=koord&w=$apo_adress_latitude;$apo_adress_longitude&z=$ap_date&a=4");
$data = json_decode($json);
$apo_coords = array();
$result .='
<div class="col-md-6">
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
<div class="sep-15"></div>
<div class="row">';

foreach ($data as $key => $item) {
  $item_counter = 1;
  @$apotheken = $item->apotheken;
  foreach ((array)$apotheken as $k => $value) {
    $result .= '<div class="col-md-6">';
    $result .= '<b>'.$value->apo . '</b></br>';
    $result .= '<p>'.$value->str . '<br>';
    $result .= $value->plz .' ' . $value->ort . '<br>';
    $result .= $value->tel . '</p></div>';
    $apo_coords[$k]['title'] = $value->apo;
    $apo_coords[$k]['lat'] = $value->lat;
    $apo_coords[$k]['lng'] = $value->lon;
    $item_counter++;
    if ($item_counter % 3 == 0) {
      $result .= '</div><div class="sep-15"></div><div class="row">';
    }
  }
}
//wp_localize_script( 'sage/js', 'apo_coords', $apo_coords );
$result .='
</div>
</div>
<div class="col-md-6">
<div id="gmap-top-bar"></div>
</div>
';

echo json_encode(array(
  "data" => $result,
  'apo_coords' => $apo_coords
));


?>
