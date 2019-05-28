<?php
error_reporting(0);
function getData($skandalDir)
{
    $path         = 'json/' . $skandalDir . '/data.json';
    // Get the contents of the JSON file 
    $jsonRead     = file_get_contents($path);
    // Convert to array 
    $skandalArray = json_decode($jsonRead, true);
    if (array_filter($skandalArray)) {
        return $skandalArray;
    } else {
        $alert = $skandalDir . 'wurde falsch exportiert.';
        return $altert;
    }
}
function getAllData()
{
    $files = getAllFiles();
    foreach ($files as $path) {
        $jsonRead    = file_get_contents($path);
        // Convert to array 
        $skandalData = json_decode($jsonRead, true);
        if (array_filter($skandalData)) {
            $allDataArray[$path] = $skandalData;
        }
    }
    return $allDataArray;
}
function date_sort($a, $b)
{
    return strtotime($a) - strtotime($b);
}

function avgDuration($allData)
{
    $i = 1;
    foreach ($allData as $dates) {
        usort($dates, "date_sort");
        if (sizeof($dates) > 1) {
            $dates = array_filter($dates);
            if (reset($dates) AND end($dates)) {
                $skandalDuration = strtotime(end($dates)) - strtotime(reset($dates));
                if ($skandalDuration == 0) {
                    $skandalDuration = 86400;
                }
                $daysPerSkandal = round($skandalDuration / 3600 / 24);
                $i++;
            }
        }
        $totalDays += $daysPerSkandal;
    }
    $avgDays = $totalDays / $i;
    return round($avgDays, 0);
}

function skandalDuration($allData)
{
    foreach ($allData as $title => $dates) {
        $title = str_replace('json/', '', dirname($title, 1));
        usort($allData, "date_sort");
        if (sizeof($dates) > 1) {
            $dates = array_filter($dates);
            if (reset($dates) AND end($dates)) {
                $skandalDuration = strtotime(end($dates)) - strtotime(reset($dates));
                if ($skandalDuration == 0) {
                    $skandalDuration = 86400;
                }
                $daysPerSkandal = abs(round($skandalDuration / 3600 / 24));
            }
        }
        $daysPerSkandalArray[$title] .= $daysPerSkandal;
    }
    arsort($daysPerSkandalArray);
    return $daysPerSkandalArray;
}
function greatFilter()
{
    $allData = getAllData();
    foreach ($allData as $title => $datesArray) {
        $title = str_replace('json/', '', dirname($title, 1));
        if (sizeof($datesArray) <= 3) { //Filtert alle Skandale mit 5 oder weniger Artikeln oder länger als 365 Tage gehen heraus
            echo 'Zu wenig Artikel für Skandal  oder <b>' . $title . '</b><br>';
        } else {
            foreach ($datesArray as $dates) {
                $newData[$title] = $datesArray;
            }
        }
    }
    foreach (skandalDuration($allData) as $key => $value) {
        if ($value > 365) {
            echo 'Skandal ist zu lang: <b>' . $key . '</b><br>';
        }
    }
}

function weeklySkandal($timespanStart, $timespanEnd, $allData)
{
    $perWeek = 0;
    $all     = 0;
    foreach ($allData as $title => $dates) {
        foreach ($dates as $date) {
            $date = strtotime($date);
            $all++;
            if ($date >= $timespanStart && $date <= $timespanEnd) {
                $perWeek++;
            }
        }
        
    }
    return $perWeek * 100 / $all;
}

function getTotalArtikel()
{
    $i    = 0;
    $json = getAllData();
    foreach ($json as $key => $skan) {
        foreach ($skan as $val) {
            $i++;
        }
    }
    echo $i;
}
?>