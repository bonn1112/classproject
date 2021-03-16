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

$listPage = 'd10home.php';

// If filmpk is not passed with page request or it's not numeric, redirect to Home Page
// Else, assign the URL parameter to a variable

if (!isset($_GET['filmpk'])|| !is_numeric($_GET['filmpk']))
{
    header('Location:' . $listPage);
    exit();
}
else
{
    $filmPK = (int) $_GET['filmpk'];
}

// instantiate a d10RWSModel object

$aModel = new d10RWSModel();

// get the movietitle associated with the filmpk
    
$aFilm = $aModel->getAMovieTitle($filmPK);

if (count($aFilm) === 1)
{
    $aTitle = $aFilm[0]['movietitle'];
}
else
{
    header('Location:' . $listPage);
    exit();
}

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Reviews for <br />'$aTitle'");

// call the getMovieReviews method

$results = $aModel->getMovieReviews($filmPK);

// call the displayReviews method

$aDisplay->displayReviews($results, $aTitle, $filmPK);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();
?>