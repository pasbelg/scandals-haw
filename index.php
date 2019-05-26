<!DOCTYPE html>
<html lang="de">
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skandale 2018</title>
  </head>
  <body>
    <?php
    error_reporting(0);
    require_once('functions/dirFunctions.php');
    require_once('functions/dataFunctions.php');
    $selectBoxes = showSkandale();
    $months = array(1=>"Januar",
    2=>"Februar",
    3=>"M&auml;rz",
    4=>"April",
    5=>"Mai",
    6=>"Juni",
    7=>"Juli",
    8=>"August",
    9=>"September",
    10=>"Oktober",
    11=>"November",
    12=>"Dezember");
    ?>
    <div class="box" id="skandalSelect">
    <form id="selectionForm" action="displaySkandal.php" method="post">
        <label>Skandal:
            <select name="skandalAuswahl">
                <?php  echo $selectBoxes;?>
            </select>
            <input type="submit" name="submit" value="Skandal auswählen" />
        </label>
    </form>
    </div>
    <div id="results">
        <div class="box" id="">
            <h2>Durchschnittliche Dauer eines Skandals im Jahr 2018</h2>
            <div id="avgDurVal">
              <?php 
              echo avgDuration(getAllData());
              ?> Tage
            </div>
      </div>
      <div class="box" id="horizontalChartBox">
          <h2>Skandale nach Monat</h2>
          <div id="horizontalChart">
            <?php 
            $timespanStart = strtotime('2018-01-01');
            $timespanEnd = strtotime('2018-01-07');
            for ($i=1; $i<=52; $i++){
              $timespanStart = strtotime('+1 weeks', $timespanStart);
              $timespanEnd = strtotime('+1 weeks', $timespanEnd);
              $barHeight = weeklySkandal($timespanStart, $timespanEnd, getAllData())*100;
              echo '<div class="nowarp bars monthlyBars" style="height:'.$barHeight.'px;">KW '.$i.'</div>';
            }
            ?>
            <br>
          <?php
            for ($i=1;$i<=12;$i++){
              echo '<div class="nowarp month" >'.$months[$i].'</div>';
            }
            ?>
            <br>
            <div id="monthDisclaimer">*Monatsangaben sind nicht exakt und dienen nur der Orientierung</div>
            <br>
          </div>

    </div>
    </div>
    <div class="box" style="height:30px;">
        <div style="float:left;">
        <a class="nowarp first after" href="http://www.bit.ly/HAWShare">Quellcode</a>
        <a class="nowarp first after" href="datenskandale.php" style="margin-left:20px;">Datenskandale</a>
        <a class="nowarp first after" href="impressum.html" style="margin-left:20px;">Impressum</a>
      </div>
  </body>
</html>