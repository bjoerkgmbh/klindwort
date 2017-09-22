<?#php get_template_part('templates/page', 'header'); ?>

<?php
$remoteJson = file_get_contents('https://v4.api.apotheken.de/api/58a2af65-d6e1-9754-3189-593a8a6aedf0/news.json');
$json = json_decode($remoteJson);

    //var_dump($json);

   foreach($json->response->news as $mydata) {
      if ($mydata->id == $atts) {
          echo '<h3 class="newssubtitle">' . $mydata->short . '</h3>';
          echo '<p class="newstitle">' . $mydata->title . '</p>';

            foreach($mydata->media as $imagedata) {
              $big = 'gross';
              if (strpos($imagedata->href, $big, 1)) {
                  echo '<img class="media-object newsimage" src="'. $imagedata->href .'" alt="'. $mydata->title .'">';
              }
          }
      }
  }
?>