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

$spaname = "";
$pitchText = "";
$ratingPK = "";

// instantiate a d10RWSDisplay object

$aDisplay = new d10RWSDisplay();



// call the displayPageHeader method

$aDisplay->displayPageHeader("Find Spa Services");

if (isset($_POST['search']))
{
    $spaname = $_POST['spaname'];
    $pitchText = $_POST['pitchtext'];
    $ratingPK = $_POST['ratingpk'];

    // remove any potentially malicious characters

    $spaname = preg_replace("/[^a-zA-Z0-9\s]/", '', $spaname);
    $pitchText = preg_replace("/[^a-zA-Z0-9\s]/", '', $pitchText);
    $ratingPK = preg_replace("/[^0-9]/", "", $ratingPK);
}

// call the displaySearchForm method

$aDisplay->displaySearchForm($spaname,$pitchText, (int)$ratingPK);

// if the user initiated a search

if (isset($_POST['search']))
{
    // instantiate a d10RWSModel object

    $aModel = new d10RWSModel();
    
    $results = $aModel->getspasByMultiCriteria($spaname,$pitchText, (int)$ratingPK);
    
    // call the displaySearchResults method

     $aDisplay->displaySearchResults($results);
}

echo  "<img src='https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/photo2.jpg' alt='Yume Shima Spa' />";
echo "<h1>Our Spa Services </h1>";

echo "<p>Services that we provide:</p>";

                    echo"<p>
                        <li>Anti-Oxidant Hot Bed Spa</li>
                        <li>Body Massage Treatments</li>
                        <li>Foot Spa</li>
                        <li>Face Treatments</li>
                        <li>Manicure and Pedicure</li>
                        <li>Waxing</li>
                        <li>Ear Candling Therapy</li>
                        <li>Hair Treatments</li></p>";

                    echo" <p>

                    <table class='programs'>
                        <caption>Yume Shima Spa</caption>
                        <colgroup>
                            <col class='timeColumn'>

                            <col span='3' class='hours'>

                            <col span='3' class='price'>
                        </colgroup>


                    <thead>
                        <tr>
                            <th>Treatments</th>
                            <th>Hours</th>
                            <th>Price</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan='3'>Copyright © 2021 The Yume Shima Spa. Designed and Maintained by Leonardy Tan and Yosuke Akutsu</td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>Anti-Oxidant Hot Bed Spa</th>
                            <td rowspan='1' colspan='1'>1.5 hours</td>
                            <td rowspan='1' colspan='1'>$40</td>

                        </tr>

                        <tr>
                            <th>Body Massage Treatments</th>
                            <td rowspan='1'>2 hours</td>
                            <td rowspan='1'>$50</td>
                        </tr>

                        <tr>
                            <th>Foot Spa</th>
                            <td colspan='1'>1 hour</td>
                            <td rowspan='1'>$30</td>

                        </tr>

                        <tr>
                            <th>Face Treatments</th>
                            <td rowspan='1' colspan='1'>1 hour</td>
                            <td rowspan='1'>$25</td>

                        </tr>


                        <tr>
                            <th>Manicure and Pedicure</th>
                            <td rowspan='1'>2 hours</td>
                            <td rowspan='1'>$30</td>
                        </tr>
                        <tr>
                            <th>Waxing</th>
                            <td rowspan='1' colspan='1'>2 hours</td>
                            <td rowspan='1'>$30</td>
                        </tr>

                        <tr>
                            <th>Ear Candling Therapy</th>
                            <td rowspan='1'>1 hour</td>
                            <td rowspan='1'>$20</td>
                        </tr>

                        <tr>
                            <th>Hair Treatments</th>
                            <td colspan='1'>1.5 hours</td>
                            <td rowspan='1'>$50</td>
                        </tr>
                     </tbody>
                     </table>";
// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>
