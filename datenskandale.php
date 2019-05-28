<?php
  error_reporting(0);
  require_once('functions/dirFunctions.php');
  require_once('functions/dataFunctions.php');
  $skandalData = getAllData();
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datenskandale</title>
  </head>
  <body>
    <div class="box">
      <h1>Datenskandale im Jahr 2018
      </h1>
    </div>
    <?php
      //print_r($skandalData);
      foreach($skandalData as $key => $dates) {
        $skandalname = str_replace('json/', '', dirname($key, 1));
        if (strpos($skandalname, 'Daten')) {
            usort($dates, "date_sort");
            $occurences = array_count_values($dates);
            $occTotal = array_sum($occurences);
            echo ' <div class = "box" id = "horizontalChartBox"><h2> Artikelverlauf von ' . $skandalname . ' </h2> <div id = "horizontalChart"> ';
            foreach($occurences as $date => $occurence) {
                $date = date("d.m. ", strtotime($date));
                if ($occTotal> 50 && array_count_values($dates) > 3) {
                    $barHeight = 30 + ($occurence * 100 / $occTotal) * 35;
                    if ($occurence>= 3) {
                        echo '<div class="nowarp bars occurenceBars" style="height:'.$barHeight.'px;">'.$date.'</div>';
                    }
                } else {
                    $barHeight = 30 + ($occurence * 100 / $occTotal) * 5;
                    if ($occurence>= 1) {
                        echo '<div class="nowarp bars occurenceBars" style="height:'.$barHeight.'px;">'.$date.'</div>';
                    }
                }
                $date = date("d.m. ", strtotime($date));
            }
            echo '</div> </div>';
        }
      }
    ?>
  </body>
</html>
