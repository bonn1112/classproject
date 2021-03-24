<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Complete Application
    Author: LV
    Date: March 2021
    Uses: d10RWSDisplay, d10RWSModel
 */
        
session_start();

// automatically load required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// assign form values to an array

$newMember = array();

$newMember['userlogin'] = (isset($_POST['userlogin'])) ? trim($_POST['userlogin']) : '';
$newMember['userpassword'] = (isset($_POST['userpassword'])) ? trim($_POST['userpassword']) : '';
$newMember['firstname'] = (isset($_POST['firstname'])) ? trim($_POST['firstname']) : '';
$newMember['lastname'] = (isset($_POST['lastname'])) ? trim($_POST['lastname']) : '';
$newMember['address'] = (isset($_POST['address'])) ? trim($_POST['address']) : '';
$newMember['city'] = (isset($_POST['city'])) ? trim($_POST['city']) : '';
$newMember['state'] = (isset($_POST['state'])) ? trim($_POST['state']) : '';
$newMember['zip'] = (isset($_POST['zip'])) ? trim($_POST['zip']) : '';
$newMember['email'] = (isset($_POST['email'])) ? trim($_POST['email']) : '';
$newMember['phone'] = (isset($_POST['phone'])) ? trim($_POST['phone']) : '';

// if the form was submitted

if (isset($_POST['register']))
{
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();

    // call checkUserName method

    $result = $aModel->checkUserName($newMember['userlogin']);
    
    if (count($result) > 0)
    {
        $error = 'Please choose a different Username';
    }
    else
    {
        // call addNewContact method

        $aModel->addNewMember($newMember);
        
        //redirect user to Sign In page

        header('Refresh: 2; URL=d10SignIn.php');
        echo '<h2>Thank you for registering.  Redirecting to Sign In Page...<h2>';
        die();
    }
}
// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("New Member Registration");

// if the user chose a duplicate username, display error

if (!empty($error))
{
    echo '<div id="error">' . $error . '</div>';
}

// call the displayRegisterForm method

$aDisplay->displayRegisterForm($newMember);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();
?>
