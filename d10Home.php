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
        //echo "<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome to Yume Shima Spa</h1>";
         echo "<img src='https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/logo2.jpg' alt='photo of me' />"; 

        echo "<p>
            <strong>Looking</strong> to get some soothing spa treatments within the confines of a luxurious, spanking-new and private facility? Discover all these only at The Yume Shima Spa, which offers a wide variety of treatments to pamper your body and soul. Located just across from the Fort Collins Shopping Centre and The Aston Hotel, The Yume Shima Spa is truly a one stop spa destination for the busy city dwellers to set their hectic minds away and unwind in coziness. It is beyond doubt the secret to your well-being. Make sure you experience these to make your journey to Fort Collins an unforgettable one.
        </p>";
        
                echo "<p>
            Be amazed by uniquely Japanese traditional ion: “Anti-Oxidant Hot Bed Spa”.
            Let it do the job to enhance blood circulation, warm up body, detoxification, relaxing sore and tensed muscle. Effective to prevent/cure flu.
        </p>";
        echo "<p>
            Using original volcanic stones from Mt. Agung in Bali. Experience the rolling stones on your body while it removes toxins, fatigue, tension & stress of your body.
            Walk away feeling energized, calmed and tranquility in your body and soul.
        </p>";
        echo"<p>
            Take a moment for yourself and enjoy the tranquil and beautiful environment created in The Yume Shima Spa. Enjoy a massage, visit our hair salon, or go all out with one of our spa packages. 
            </p>";
        echo"<p>Be sure to check out our <a href='https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/d10Search.php'> Spa services</a> </p>";

        //echo'<p><a href="https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/HtmlCss/services.html">services</a></p>'; 
        echo "<img src='https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/photo1.jpg' alt='photo of me' />";
        
        echo"<p>Schedule your appointment today: <a href=\'https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/d10SignIn.php'>Contact us</a></p>";
        
        //echo'<a href=\\"https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/HtmlCss/contacts.html">Contact us</a>';
        echo"<p>
            Phone: <a href='tel:+15033341868'>(503) 334-1868</a>
        </p>";
        
        //echo'<a href="tel:+15033341868">(503) 334-1868</a>';
        echo"<p>
            E-mail: <a href='mailto:yumeshimaspa@gmail.com'>yumeshimaspa@gmail.com</a>
        </p>";
       // echo'<a href="mailto:yumeshimaspa@gmail.com">yumeshimaspa@gmail.com</a>';
                
    }
?>

<p>Find information about our classic and contemporary films and read member reviews.  Become a member today to add your own reviews. We know you are a better judge of our films than those snooty "critics" at the Collegian.</p>
<p>Enjoy your visit. Have fun!</p>

<?php
    // call the displayPageFooter method 

    $aDisplay->displayPageFooter();
?>