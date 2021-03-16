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

$homePage = 'd10Home.php';
$contactPK = (int) $_SESSION['userInfo']['contactpk'];

if ((isset($_POST['reviewpk'])) && (is_numeric($_POST['reviewpk'])))
{
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();

    $aModel->deleteReview((int)$_POST['reviewpk'], $contactPK);
    $message = "You have deleted your review";
}
else
{
    $message = "Invalid or missing review";
}
header('Refresh: 2; URL=d10MyReviews.php');
echo "<h2>$message. Redirecting to your reviews page.<h2>";
exit;

?>

