<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Complete Application
    Author: LV
    Date: March 2021
    Uses: d10RWSDisplay
 */
        
session_start();

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Home Page");

// the session array element "userInfo" will be set if the user has been authenticated

$userFName = (isset($_SESSION['userInfo']))? $_SESSION['userInfo']['firstname'] : "";   

// if the user is authenticated, customize greeting"

if (!empty($userFName))
    {
        echo "<p>Welcome back to Spa course, $userFName!</p>";
    }
    else
    {
        echo "<p>Hello, and welcome to Spa course</p>";
    }
?>

<p>Find information about our classic and contemporary films and read member reviews.  Become a member today to add your own reviews. We know you are a better judge of our films than those snooty "critics" at the Collegian.</p>
<p>Enjoy your visit. Have fun!</p>

<?php
    // call the displayPageFooter method 

    $aDisplay->displayPageFooter();
?>