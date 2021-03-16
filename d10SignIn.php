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

// Set local variables to $_POST array elements (username and userpassword) or empty strings

$userLogin = (isset($_POST['userlogin'])) ? trim($_POST['userlogin']) : '';
$userPassword = (isset($_POST['userpassword'])) ? trim($_POST['userpassword']) : '';
   
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'd10Home.php';

// if the form was submitted

if (isset($_POST['signin']))
{
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();

    // call getUserData method

    $userList = $aModel->getUserData($userLogin, $userPassword);

    if (count($userList)==1) //If credentials check out
    {
        extract($userList[0]);

        // assign user info to an array

        $userInfo = array('contactpk'=>$contactpk, 'firstname'=>$firstname, 'userrole'=>$userrolename);

        // assign the array to a session array element

        $_SESSION['userInfo'] = $userInfo;
        session_write_close();

        // redirect the user

        header('location:' . $redirect);
        die();
    }

    else // Otherwise, assign error message to $error
    {
        $error = 'Invalid credentials<br />Please try again';
    }
}

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Sign In Form");

// if error variable was set, display it

if (isset($error))
{
    echo '<div id="error">' . $error . '</div>';
}

// call the displaySignInForm method

$aDisplay->displaySignInForm($userLogin, $userPassword, $redirect);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>