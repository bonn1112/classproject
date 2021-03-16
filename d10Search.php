<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Complete Application
    Author: LV
    Date: March 2021
    Uses: d10RWSDisplay, d10RWSModel
*/

session_start();

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

$movieTitle = "";
$pitchText = "";
$ratingPK = "";

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Find Films");

if (isset($_POST['search']))
{
    $movieTitle = $_POST['movietitle'];
    $pitchText = $_POST['pitchtext'];
    $ratingPK = $_POST['ratingpk'];

    // remove any potentially malicious characters

    $movieTitle = preg_replace("/[^a-zA-Z0-9\s]/", '', $movieTitle);
    $pitchText = preg_replace("/[^a-zA-Z0-9\s]/", '', $pitchText);
    $ratingPK = preg_replace("/[^0-9]/", "", $ratingPK);
}

// call the displaySearchForm method

$aDisplay->displaySearchForm($movieTitle,$pitchText, (int)$ratingPK);

// if the user initiated a search

if (isset($_POST['search']))
{
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();
    
    $results = $aModel->getFilmsByMultiCriteria($movieTitle,$pitchText, (int)$ratingPK);
    
    // call the displaySearchResults method

     $aDisplay->displaySearchResults($results);
}

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>