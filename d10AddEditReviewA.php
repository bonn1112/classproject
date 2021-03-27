<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Complete Application
    Author: LV
    Date: March 2021
    Uses: d10RWSAuthCheck, d10RWSModel
 */
        
session_start();

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// call the static method in d10RWSAuthCheck to check if the user is authenticated

d10RWSAuthCheck::isAuthenticated($_SERVER['PHP_SELF']);

session_start();

$myReviewsPage = 'd10MyReviews.php';

// if $_POST has a reviewpk element, call the update method

if (isset($_POST['reviewpk']))
{
    $aModel = new d10RWSModel();
    
    $aModel->updateReview((int)$_POST['reviewpk'], $_POST['reviewsummary'], (int) $_POST['reviewrating']);
    $message = "You have updated your review";
}
elseif (isset($_POST['treatments_id'])) // if $_POST has a filmpk element,call the add method
{
    $contactPK = (int) $_SESSION['userInfo']['contactpk'];
    
    $aModel = new d10RWSModel();
    
    if (!isset($_POST['reviewsummary']))
    {
        echo "error Null not given";
    }elseif (!isset($_POST['reviewrating']))
    {
        echo "error Null not given";
    }

    $aModel->addNewReview($_POST['reviewsummary'], 
            (int)$_POST['reviewrating'], (int)$_POST['treatments_id'], $contactPK);
    $message = "You have added a review";
}


header("Refresh: 3; URL=$myReviewsPage");
echo "<h2>$message. Redirecting to your reviews page....<h2>";
exit;

?>

