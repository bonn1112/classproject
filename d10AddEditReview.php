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

$homePage = 'd10Home.php';
$contactPK = (int) $_SESSION['userInfo']['contactpk'];

// declare and initialize Add/Edit flag variable

$editmode = false;

// if a numeric spapk was passed through the URL

if ((isset($_GET['treatments_id'])) && (is_numeric($_GET['treatments_id'])))
{
    $spapk = (int) $_GET['treatments_id'];
    
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();

    // get the spaname associated with the spapk
    
    $aSpa = $aModel->getAspaname($spapk);

    if (count($aSpa) !== 1)
    {
        header('Location:' . $homePage);
        exit();
    }
    else
    {
        $formTitle = "Add a review for <br /> '{$aSpa[0]['treatment']}'";
    }    
}
// elseif a numeric reviewpk was passed through the URL

elseif ((isset($_GET['reviewpk'])) && (is_numeric($_GET['reviewpk'])))
{
    $reviewPK = (int) $_GET['reviewpk'];
    
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();

    // get the details for the review to be edited
    
    $reviewDetails = $aModel->getReviewDetails($reviewPK, $contactPK);
    
    // if a review is not returned for the reviewpk, redirect to home page
    
    if (count($reviewDetails) !==  1)
    {
        header('Location:' . $homePage);
        exit();
    }
    else
    {
        $formTitle = "Update your review of <br /> '{$reviewDetails[0]['treatment']}'";
        $editmode = true;
    }
}
 // else (i.e., this page was accessed without a valid spapk or reviewpk), redirect to home page
 else
 {
     header('Location:' . $homePage);
     exit();
 }
 
// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader($formTitle);

// call displayAddEditReviewForm method

if ($editmode)
{
    $aDisplay->displayAddEditReviewForm($reviewPK, $reviewDetails);
}
 else 
{
     $aDisplay->displayAddEditReviewForm($spapk);
}

// call the displayPageFooter method 

$aDisplay->displayPageFooter();
?>
