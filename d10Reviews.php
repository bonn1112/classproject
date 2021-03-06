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

// $listPage = 'd10home.php';

// If spapk is not passed with page request or it's not numeric, redirect to Home Page
// Else, assign the URL parameter to a variable

if (!isset($_GET['treatments_id'])|| !is_numeric($_GET['treatments_id']))
{
    header('Location:' . $listPage);
    exit();
}
else
{
    $spapk = (int) $_GET['treatments_id'];
}

// instantiate a d10RWSModel object

$aModel = new d10RWSModel();

// get the spaname associated with the spapk
    
$aSpa = $aModel->getAspaName($spapk);

if (count($aSpa) === 1)
{
    $aTitle = $aSpa[0]['treatment'];
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

$results = $aModel->getSpaReviews($spapk);

// call the displayReviews method

$aDisplay->displayReviews($results, $aTitle, $spapk);


                

// call the displayPageFooter method 

$aDisplay->displayPageFooter();
?>