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

echo "<br><br><br><br><br><br><br><br>";
echo "<h1>Wanna know about us more? <br><br><img src='https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/photo3.jpg' alt='Yume Shima Spa' /></h1></p></p>";
        echo"<p>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

            <!-- Add font awesome icons -->
            <a href='#' class='fa fa-facebook'></a>

            Please check out our facebook page:<br />

            <a href='https://www.facebook.com/Yume-Shima-Batam-Hot-Bed-Spa-%E5%B2%A9%E7%9B%A4%E6%B5%B4-470527689653417/'>Yume Shima Spa Facebook Web</a>
        </p>";

        echo" <p>
            Services that we provide:
            The Yume Shima Spa, like the name, it is a secret place to reveal your well-being. With a contemporary Balinese concept, we aim to create a clean, cozy, and comfortable ambience for our guests with a strict no-smoking policy in effect.

        </p>
            
       
            We present only natural ingredients, the purest aromatherapy oils and premium herbs with the rituals and methods that have been proven to be the most effective physical and spiritual heals. From our Traditional Herbal Spa that uses uniquely Indonesian herb and Japanese Ion 'Anti-Oxidant Hot Bed Spa' to the Yume Shima Spa that uses grape for body scrub and red wine for bathe. Without a doubt, we are offering a wide variety of treatments you can choose from.
        </p>
               
       
            Other in-house services and treatments offered include body massage treatments, foot spa, face treatments, manicure and pedicure, waxing, ear candling therapy and hair treatments.
        </p>
        <p>
            The relieving hands of our well-trained therapists with blends of natural products used in treatments enhance our guests to achieve the full set of pleasure and serenity. Feel better, look better and walk away feeling energized, calmed and tranquility in your body and soul.
        </p>";

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>