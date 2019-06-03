<?php
  /*Generieren von Skandalverläufe aller Datenskandale
  Es wird fast der gleich Code wie bei "displaySkandale.php" verwendet es werden nur mehrere Skandalverläufe angezeigt.
  Diese werden jedoch nach Datenskandalen gefiltert.
  */
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
      
      foreach($skandalData as $key => $dates) {
        $skandalname = str_replace('json/', '', dirname($key, 1));
        //Filterung von Skandalen welche "Daten" im Namen haben.
        if (strpos($skandalname, 'Daten')) {
            //Sortieren der Datumsangaben von Früh zu Spät.
            usort($dates, "date_sort");
            //Zählen der Veröffentlichungen pro Skandal.
            $occurences = array_count_values($dates);
            //Speichern der Gesammtsumme um den Prozentualen Anteil zu berechnen
            $occTotal = array_sum($occurences);
            //Ausgabe der Abschnitte welchen die einzelnen Datenskandale enthalten
            echo ' <div class = "box" id = "horizontalChartBox"><h2> Artikelverlauf von ' . $skandalname . ' </h2> <div id = "horizontalChart"> ';
            foreach($occurences as $date => $occurence) {
                $date = date("d.m. ", strtotime($date));
                //Verschiedene Säulenhöhe von Skandalen mit großem oder kleinem Medieninteresse
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
