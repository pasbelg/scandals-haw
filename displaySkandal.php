<?php
  error_reporting(0);
  require('functions/dataFunctions.php');
  if (isset($_POST['submit'])) {
      if (!empty($_POST['skandalAuswahl'])) {
          $skandal = $_POST['skandalAuswahl'];
      } else {
          $skandal = 'Kein Skandal ausgewählt';
      }
      $datenArray = getData($skandal);
      usort($datenArray, "date_sort");
      if (is_array($datenArray)) {
          $occurences = array_count_values($datenArray);
          $occTotal = array_sum($occurences);
      } else {
          $error = $datenArray;
      }
  }
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      <?php echo $_POST['skandalAuswahl']?>
    </title>
  </head>
  <body>
    <div class="box">
      <h1>Details zu 
        <b>
          <?php echo $skandal; ?>
        </b>
      </h1>
    </div>
    <div class="box" id="horizontalChartBox">
      <h2>Artikelverlauf
      </h2>
      <div id="horizontalChart">
        <?php
          foreach($occurences as $date => $occurence) {
            $date = date("d.m. ", strtotime($date));
            if ($occTotal > 50) {
                $barHeight = 30 + ($occurence * 100 / $occTotal) * 9;
                if ($occurence >= 3) {
                    echo '<div class="nowarp bars occurenceBars" style="height:'.$barHeight.
                    'px;">'.$date.
                    '</div>';
                }
            } else {
                if ($occurence > 1) {
                    $barHeight = 30 + ($occurence * 100 / $occTotal) * 4;
                    echo '<div class="nowarp bars occurenceBars" style="height:'.$barHeight.
                    'px;">'.$date.
                    '</div>';
                } else {
                    $barHeight = 30 + $occurence * 10;
                    echo '<div class="nowarp bars occurenceBars" style="height:'.$barHeight.
                    'px;">'.$date.
                    '</div>';
                }
            }
            $date = date("d.m. ", strtotime($date));
          }
        ?>
        <br>
        <br>
      </div>
    </div>
  </body>
</html>
