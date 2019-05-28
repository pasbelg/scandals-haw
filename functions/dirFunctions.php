<?php
error_reporting(0);
function getAllFiles()
{
    $jsonFolder = 'json/';
    $skandale   = array_diff(scandir($jsonFolder), array(
        '.',
        '..'
    ));
    foreach ($skandale as $skandalFolder) {
        $skandaleJSON = array_diff(scandir($jsonFolder . $skandalFolder), array(
            '.',
            '..'
        ));
        foreach ($skandaleJSON as $jsonFile) {
            $allFiles[] .= $jsonFolder . $skandalFolder . '/' . $jsonFile;
        }
    }
    return $allFiles;
}

function showSkandale()
{
    $jsonFolder = 'json/';
    $skandale   = array_diff(scandir($jsonFolder), array(
        '.',
        '..'
    ));
    foreach ($skandale as $skandalFolder) {
        $skandaleJSON = array_diff(scandir($jsonFolder . $skandalFolder), array(
            '.',
            '..'
        ));
        foreach ($skandaleJSON as $jsonFile) {
            $skandalName = basename($jsonFile, '.HTML.json');
            $jsonFiles .= '<option value="' . $skandalFolder . '">' . $skandalFolder . '</option>';
        }
    }
    return $jsonFiles;
}

function wrongHTML()
{
    $files = getAllFiles();
    foreach ($files as $path) {
        $jsonRead    = file_get_contents($path);
        $skandalData = json_decode($jsonRead, true);
        if (!array_filter($skandalData)) {
            echo str_replace('json/', '', dirname($path, 1)) . '<br>';
        }
    }
}
?>