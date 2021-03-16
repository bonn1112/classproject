<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Complete Application
    Author: LV
    Date: March 2021
    Uses: d10RWSAuthCheck, d10RWSDisplay, d10RWSModel
*/

session_start();

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// call the static method in d10RWSAuthCheck to check if the user is authenticated

d10RWSAuthCheck::isAuthenticated($_SERVER['PHP_SELF']);

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Edit/Delete your Reviews");

// instantiate a d10RWSModel object

$aModel = new d10RWSModel();

// get reviews for user

$results = $aModel->getUserReviews((int)$_SESSION['userInfo']['contactpk']);

// call the displayUserReviews method

$aDisplay->displayUserReviews($results);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>
