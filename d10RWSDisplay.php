<?php declare(strict_types=1);
/* 
    Purpose: Demo 10 - Class for getting data for and displaying data from RW Studios DB
    Author: LV
    Date: March 2021
    Uses: d10StylesRWS.css, d10RWSNodel.php
*/

// automatically loads required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

class d10RWSDisplay
{
    // method to display page header
    
    function displayPageHeader(string $pageTitle)
    {
        $output = <<<ABC
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <meta charset="UTF-8" />
                            <title>Spa</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1" />  
                            <link rel="stylesheet" href="d10StylesRWS.css" type="text/css" />
                        </head>

                        <body>
                            <header>
                                <h2>Welcome to Yume Shima Spa</h2>
                            </header>
                            
                            <nav>
                                <ul>
                                    <li><a href="d10Home.php">Home</a></li>
                                    <li><a href="d10Search.php">Search Spa</a></li>
                                    <li><a href="d10MyReviews.php">Spa Reviews</a></li>
                    ABC;
        // the session array element "userInfo" will be set if the user has been authenticated

        $authStatus = (isset($_SESSION['userInfo']));   

        // if the user is authenticated, display "Sign Out", else Sign In/Register"

        if ($authStatus)
        {
            $output .= '<li><a href="d10SignOut.php">Sign Out</a></li>';
        }
        else
        {
            $output .= '<li><a href="d10SignIn.php">Sign In/Register</a></li>';
        }

        $output .= "</ul></nav><section>";
        
        echo $output;
    }
   
    // method to display page footer
    
    function displayPageFooter()
    {
       $year = date('Y');
       $output = <<<ABC
               </section>
               <footer>
               <address>
                  &copy; $year Yume Shima Spa
               </address>
            </footer>   
          </body>
         </html>
         ABC;
        echo $output;
    }
     //<label for="pitchtext">Tag Line:</label>
      //              <input type="text" name="pitchtext" id="pitchtext" maxlength="50" value="$aPitch" />
    
    function displaySearchForm (string $aTitle, string $aPitch, int $aRatingPK) : void
    {
        $output = <<<HTML
                    <div><br>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="d9Viewcart.php">View Cart</a>
                    </div><br>
                    <form action="d10Search.php" method = "post" name="SearchByMultiCriteria" id="SearchByMultiCriteria">
                    <label for="spaname">Spa Title:</label>
                    <input type="text" name="spaname" id="spaname" maxlength="50" value="$aTitle" />
                   
                    <label for="rating">Spa Rating:</label>
                    <select name="ratingpk" id="rating">
                
                    
                    <option value=""></option>
                
                    <label> <h1> Our Services  <img src="https://cisweb.biz.colostate.edu/cis665/SP21Tan.studia/PHPDemos/PhpProject/photo2.jpg" alt="Yume Shima Spa" /></h1></label>
        
                     <p>Services that we provide:</p>

                    <ul>
                        <li>Anti-Oxidant Hot Bed Spa</li>
                        <li>Body Massage Treatments</li>
                        <li>Foot Spa</li>
                        <li>Face Treatments</li>
                        <li>Manicure and Pedicure</li>
                        <li>Waxing</li>
                        <li>Ear Candling Therapy</li>
                        <li>Hair Treatments</li>


                    </ul>

                     <p>

                    <table class="programs">
                        <caption>Yume Shima Spa</caption>
                        <colgroup>
                            <col class="timeColumn">

                            <col span="1" class="hours">

                            <col span="1" class="price">
                        </colgroup>


                    <thead>
                        <tr>
                            <th>Treatment</th>
                            <th>Hours</th>
                            <th>Price</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="8">Copyright ?? 2021 The Yume Shima Spa. Designed and Maintained by Leonardy Tan and Yosuke Akutsu</td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>Anti-Oxidant Hot Bed Spa</th>
                            <td rowspan="1" colspan="1">1.5 hours</td>
                            <td rowspan="1" colspan="2">$40</td>

                        </tr>

                        <tr>
                            <th>Body Massage Treatments</th>
                            <td rowspan="1">2 hours</td>
                            <td rowspan="1">$50</td>
                        </tr>

                        <tr>
                            <th>Foot Spa</th>
                            <td colspan="1">1 hour</td>
                            <td rowspan="1">$30</td>

                        </tr>

                        <tr>
                            <th>Face Treatments</th>
                            <td rowspan="1" colspan="1">1 hour</td>
                            <td rowspan="1">$25</td>

                        </tr>


                        <tr>
                            <th>Manicure and Pedicure</th>
                            <td rowspan="1">2 hours</td>
                            <td rowspan="1">$30</td>
                        </tr>
                        <tr>
                            <th>Waxing</th>
                            <td rowspan="1" colspan="1">2 hours</td>
                            <td rowspan="1">$30</td>
                        </tr>

                        <tr>
                            <th>Ear Candling Therapy</th>
                            <td rowspan="1">1 hour</td>
                            <td rowspan="1">$20</td>
                        </tr>

                        <tr>
                            <th>Hair Treatments</th>
                            <td colspan="1">1.5 hours</td>
                            <td rowspan="1">$50</td>
                        </tr>
                     </tbody>
                     </table>
                HTML;
        
        // instantiate a d10RWSModel object

        $aModel = new d10RWSModel();

        // call the getspaRatings method

        $ratingsList = $aModel->getspaRatings(); 
         
        foreach ($ratingsList as $aRating)
        {
            extract($aRating);
            if ($ratingpk == $aRatingPK)
            {
                $output .= <<<HTML
                            <option value="$ratingpk" selected="true">$rating</option>
                        HTML;
            }
            else
            {
                $output .= <<<HTML
                            <option value="$ratingpk">$rating</option>
                        HTML;
            }
        }
        
        $output .= <<<HTML
                        </select>
                        <p><input name = "search" type="submit" value="Search" /></p>
                        </form>
                HTML;
        echo $output;
    }

    function displaySearchFormCart(string $aName) : void
    {
        $output = <<<HTML
                    <div>
                        <a href="d9Viewcart.php">View Cart</a>
                    </div>
                    <form action="d9ShopSearch.php" method = "post">
                        <h2 style="text-align: center">Spa courses</h2>

                        <label for="coursename">coursename:</label>

                        <!-- Todo You can add the courses -->

                        <input type="text" name="coursename" id ="coursename" maxlength="50" 
                            autofocus pattern="^[a-zA-Z\s]*$" title="Letters only" value="$aName" />
                        <p>
                            <input type="submit" value="Search" name="search" />
                        </p>
                    </form>
                HTML;
        echo $output;
    }
    
    function displaySearchResults(array $aResults): void
    {
        $count = count($aResults);
        
        if ($count === 0)
        {
            echo "<h3>No matching spa(s) found</h3>";
            return;
        }
        
        $output = <<<HTML
                    <table>
                    <caption>$count spa(s) found</caption>
                        <tbody>
                    <h2 style="text-align: center">$merchandisename</h2>
                    <form action="d9UpdateCart.php" method = "post">
                    <input type="hidden" name="merchandisepk" value =$merchandisepk />
                HTML;
        
        $spaNum = 0;

        foreach ($aResults as $aspa)
        {
            extract($aspa);
            $spaNum ++;
            $spapk = urlencode(($treatments_id));
            //$dateReleased = date_format(new DateTime($dateintheaters), "F j, Y");
        
            $output .= <<<HTML
                        <tr>
                            <td>$spaNum: $treatment for $hours is $$price<br />
                                
                            </td>
                            
                            <td>
                                $dateReleased <br />
                                <a href="d10Reviews.php?treatments_id=$treatments_id">View Reviews</a>
                            </td>
                    
                            <td>
                                $dateReleased <br />
                                <a href="d10AddEditReview.php?treatments_id=$treatments_id">Add Reviews</a>
                            </td>

                            <td>
                                <input name = "submit" type="submit" value="Make RSVP" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                            $summary
                            </td>
                        </tr>
                    HTML;
            }
    
        $output .= "<tbody></table>";
    
        echo $output;
    }

    function displayShopCart(array $aList) : void
    {
        // get a count of the number of items in the cart

        $cartItems = count($aList);

        // prepare the output using heredoc syntax

        $output = <<<HTML
                    <h2 style="text-align: center">You have $cartItems product(s) in your cart</h2>
                    <table>
                        <tr>
                            <th>Course</th>
                            <th>During</th>
                            <th>Unit Price</th>
                            <th>Extended price</th>
                        </tr>
                HTML;

        foreach ($aList as $aItem)
        {
            extract($aItem);
            $merchandiseQty = $_SESSION['aCart']->getQtyByMerchandiseID((int)$merchandisepk);
            $extendedPrice = $merchandiseQty * $merchandiseprice;
            $totalPrice += $extendedPrice;
            $formattedExtendedPrice = number_format($extendedPrice, 2);
            $formattedPrice = number_format((float)$merchandiseprice, 2);
            $output .= <<<HTML
                        <tr>
                            <td>
                                $merchandisename
                            </td>
                            <td>
                                <form action="d9UpdateCart.php" method="post">
                                    <input type="hidden" name="merchandisepk" value="$merchandisepk" />
                                    <input type="number" name="merchandiseqty" 
                                        value="$merchandiseQty" size="2" maxlength="2" 
                                        required="required" min="0" max="20" />
                                    <input type="submit" name=submit" value="Update Quantity" />
                                </form>
                            </td>
                            <td style="text-align: right">
                                $$formattedPrice
                            </td>
                            <td style="text-align: right">
                                $$formattedExtendedPrice
                            </td>
                        </tr>
                    HTML;
        }
        $formattedTotalPrice = number_format($totalPrice,2);
        $output .= <<<HTML
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <b>Your order total is: $$formattedTotalPrice</b>
                            </td>
                            <td colspan="2" style="text-align: center">
                                <form action="d9CheckOut.php" method="post">
                                    <input type="submit" name="submit" id="proceed" value = "Proceed to Checkout" />
                                </form>
                            </td>
                        </tr>
                    </table>
                    <p style="text-align: center">
                        <a href="d9ShopSearch.php">[Continue shopping]</a>
                    </p>
                HTML;

        // display the output

        echo $output;
    }
    
    function displayCheckOut(array $aList) : void
    {
        // get a count of the number of items in the cart

        $cartItems = count($aList);

        $contactName = $_SESSION['userInfo']['firstname'];

        $output = <<<HTML
                    <h2 style="text-align: center">Hi $contactName, You have $cartItems product(s) in your cart</h2>
                    <table>
                        <tr>
                            <th>Course</th>
                            <th>During</th>
                            <th>Unit Price</th>
                            <th>Extended price</th>
                        </tr>
                HTML;

        foreach ($aList as $aItem)
        {
            extract($aItem);
            $merchandiseQty = $_SESSION['aCart']->getQtyByMerchandiseID((int)$merchandisepk);
            $extendedPrice = $merchandiseQty * $merchandiseprice;
            $totalPrice += $extendedPrice;
            $formattedExtendedPrice = number_format($extendedPrice, 2);
            $formattedPrice = number_format((float)$merchandiseprice, 2);
            $output .= <<<HTML
                            <tr>
                                <td>
                                    $merchandisename
                                </td>
                                <td style="text-align: right; font-style: normal">
                                    $merchandiseQty
                                </td>
                                <td style="text-align: right">
                                    $$formattedPrice
                                </td>
                                <td style="text-align: right">
                                    $$formattedExtendedPrice
                                </td>
                            </tr>
                        HTML;
        }
        $formattedTotalPrice = number_format($totalPrice,2);
        $output .= <<<HTML
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <b>Your order total is: $$formattedTotalPrice</b>
                            </td>
                            <td colspan="2" style="text-align: center">
                            <form action="d9PlaceOrder.php" method="post">
                                <input type="submit" name="submit" value = "Place Order" />
                            </form>
                            </td>
                        </tr>
                    </table>
                    <p style="text-align: center">
                        <a href="d9ShopSearch.php">[Continue shopping]</a>
                    </p>
                HTML;

        // display the output

        echo $output;
    }
    
    function displayReviews(array $aResults, string $aTitle, int $aPK): void
    {
        $count = count($aResults);
        
        if ($count === 0)
        {
            echo "<h3 style=\"text-align:center\">No reviews for $aTitle</h3>";
        }
        else
        {
            $output = <<<HTML
                        <table>
                        <caption>$count review(s) found</caption>
                            <tbody>
                    HTML;

            foreach ($aResults as $aReview)
            {
                extract($aReview);
                
                $reviewpk = urlencode(($ReviewPK));
                $reviewdate = date_format(new DateTime($ReviewDate), "F j, Y");

                $output .= <<<HTML
                            <tr>
                                <td colspan="3">
                                    $ReviewSummary
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    $ReviewRating Stars
                                </td>
                                <td>
                                    Review Date: $reviewdate
                                </td>
                                <td>
                                    Reviewer: $FirstName $LastName
                        HTML;
                if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['contactpk']===$contactfk)
                {    
                    $output .= <<<HTML
                                    <br />
                                    <a href="d10AddEditReview.php?reviewpk=$reviewpk">Edit Review</a>
                            HTML;
                }
                $output .= "</td></tr>";
            }
            $output .= "<tbody></table>";
        }
        $output .= <<<HTML
                        <p style="text-align: center">
                            <a href="d10AddEditreview.php?treatments_id=$aPK">[Review spa]</a> 
                                &nbsp;&nbsp;<a href="d10Search.php">[Back to Search Page]</a>
                        </p>
                    HTML;
        echo $output;
    }
    
    function displayUserReviews(array $aResults): void
    {
        $count = count($aResults);
        
        if ($count === 0)
        {
            echo '<h3 style="text-align:center">You don\'t have reviews. <a href="d10Search.php">
                Find spas to review</a></h3>';
        }
        else
        {
            $output = <<<HTML
                        <table>
                        <caption>{$_SESSION['userInfo']['firstname']}, you have $count review(s)</caption>
                            <tbody>
                    HTML;

            foreach ($aResults as $aReview)
            {
                extract($aReview);
                $reviewpk = urlencode(trim($reviewpk));
                $reviewdate = date_format(new DateTime($reviewdate), "F j, Y");

                $output .= <<<HTML
                            <tr>
                                <td>
                                    $spaname
                                </td>
                                <td colspan="3">
                                   <b>$treatment</b> 
                                </td>
                            </tr>                         
                            <tr>
                                <td>
                                    $spaname
                                </td>
                                <td colspan="3">
                                    $reviewsummary
                                </td>
                            </tr>
                            
                            <tr>
                                <td >
                                    $reviewrating Stars
                                </td>
                                <td>
                                    Review Date: $reviewdate
                                </td>
                                <td>
                                    <a href="d10AddEditReview.php?reviewpk=$reviewpk">[Edit]</a>
                                </td>
                                <td>
                                    <form action="d10DeleteReview.php" method="post" id="deleteReview">
                                        <input type="hidden" name="reviewpk" value="$reviewpk" />
                                        <input type="submit" value="Delete"
                                            onclick="return confirm('Delete Review?');" />
                                    </form>
                                </td>
                            </tr>
                        HTML;
            }
            $output .= "<tbody></table>";
        }
        echo $output;
    }
    
    // this method is used to either display a form to add or update a review
    // the second parameter is optional, and not needed for adding a new review
    
    function displayAddEditReviewForm(int $aPK, array $aReview = array()) : void
    {
        if (empty($aReview))
        {
            $reviewsummary = '';
            $reviewrating = '';
            $buttonText = 'Add';
            $hiddenInputName = 'spapk';
        }
        else
        {
            extract($aReview[0]);
            $buttonText = 'Update';
            $hiddenInputName = 'reviewpk';
        }
                        
        $output = <<<HTML
                        <form action="d10AddEditReviewA.php" name="addEditForm" id="addEditForm" method="post">
                        <input type="hidden" name ="$hiddenInputName" value = "$aPK" />
                        <label for="reviewsummary">Review Summary:</label> 
                        <input type="text" name="reviewsummary" id="reviewsummary" maxlength="100" value="$reviewsummary" 
                            autofocus required="true" pattern="^[a-zA-Z0-9][\w\s&,]*[a-zA-Z0-9!\?\.]$" 
                            title="Please delete the old review and update new review" /><br /><br />
                        <label for="reviewrating" id="rr">Review Rating (1 to 5 Stars):</label>
                        <select name="reviewrating" id="reviewrating">
                HTML;
        
        foreach (range(1,5) as $aRating)
        {
            if ($aRating == $reviewrating)
            {
                $output .= <<<HTML
                                <option value="$aRating" selected="selected">$aRating</option>
                        HTML;
            }
            else
            {
               $output .= <<<HTML
                        <option value="$aRating">$aRating</option>
                        HTML;
            }
        }
        
        $output .= <<<HTML
                    </select><br />
                    <p>
                        <input type="submit" value="$buttonText" />
                        <a href="d10Home.php">Cancel</a>
                    </p></form>
                HTML;
        
        echo $output; 
    }
    
    function displaySignInForm (string $aUserLogin, string $aUserPassword, string $aRedirect) : void
    {
        $output = <<<HTML
                    <form action="d10SignIn.php" name="signInForm" id="signInForm" method="post">
                    <!-- Store the redirect file name in a hidden field  -->
                    <input type="hidden" name ="redirect" value = "$aRedirect" />
                    <label for="userlogin">Username:</label>
                    <input type="text" name="userlogin" id ="userlogin" value= "$aUserLogin" 
                        maxlength="10" autofocus="autofocus" required="true" 
                        pattern="^[\w@\.]+$" title="User Name has invalid characters" />
                    <label for="userpassword">Password:</label> 
                    <input type="password" name="userpassword" id="userpassword" value="$aUserPassword" 
                        maxlength="10" required="true" pattern="^[\w@\.]+$" 
                        title="Password has invalid characters" />
                    <p>
                        <input type="submit" value="Sign In" name="signin" /> <br />
                        Not a Member?  <a href="d10Register.php">Register Here</a>
                    </p>
                    </form>
                HTML;
                
        echo $output;
    }
    
    function displayRegisterForm (array $aMemberData) : void
    {
        // extract array data
        
        extract($aMemberData);
        
        // prepare the checked attribute for Mailing List Checkbox
        
        $checked = ($mailinglist) ? "checked = \"checked\"" : ""; 
                            
        $output = <<<HTML
                    <form name ="registerForm" id="registerForm" action="d10Register.php" method="post">
                        <label for="userlogin">Username:</label>
                        <input type="text" name="userlogin" id ="userlogin" value="$userlogin" 
                            class="ten" maxlength="10" autofocus="true" required="true" 
                            pattern="^[\w@\.]+$" title="Valid characters are a-z 0-9 _ . @" />
                        <label for="userpassword">Password:</label> 
                        <input type="password" name="userpassword" id="userpassword" value="$userpassword" 
                            class="ten" maxlength="10" required="true" 
                            pattern="^[\w@\.]+$" title="Valid characters are a-z 0-9 _ . @" />
                        <label for="firstname">First Name:</label>
                        <input type="text" name="firstname" id ="firstname" value="$firstname" 
                            maxlength="20" class="twenty" required="true" pattern="^[a-zA-Z\-]+$" 
                            title="First Name has invalid characters" />
                        <label for="lastname">Last Name:</label>
                        <input type="text" name="lastname" id ="lastname" value="$lastname" 
                            maxlength="20" class="twenty" required="true" pattern="^[a-zA-Z\-]+$" 
                            title="Last Name has invalid characters" />
                        <label for="address">Address:</label>
                        <input type="text" name="address" id ="address" value="$address" 
                            maxlength="30" class="twenty" required="true" 
                            pattern="^[a-zA-Z0-9][\w\s\.]*[a-zA-Z0-9\.]$" title="Address has invalid characters" />      
                        <label for="city">City:</label>
                        <input type="text" name="city" id ="city" value="$city" maxlength="20" 
                            class="twenty" required="true" pattern="^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$" 
                            title="City has invalid characters" />
                        <label for="state">State:</label>
                        <input type="text" name="state" id="state" value="$state" maxlength="2" 
                            required="true" pattern="^[a-zA-Z]{2}$" title="Enter a valid state" />
                        <label for="zip">Zip:</label>
                        <input type="text" name="zip" id ="zip" value="$zip" maxlength="10" 
                            class="ten" required="true" pattern="^\d{5}(-\d{4})?$" 
                            title="Enter a valid 5 or 9 digit zip code" />    
                        <label for="email">Email:</label>
                        <input type="text" name="email" id ="email" value="$email" maxlength="50" 
                            class="twenty" required="true" pattern="^[\w\-\.]+@[\w]+\.[a-zA-Z]{2,4}$" 
                            title="Enter a valid email" /> 
                        <label for="phone">Telephone:</label>
                        <input type="text" name="phone" id ="phone" value="$phone" maxlength="12" 
                            class="ten" required="true" pattern="^(\d{3}-)?\d{3}-\d{4}$" 
                                title="Enter a valid phone number" />
                        <p>
                            <input type="submit" value="Register" name="register" /> <br />
                        </p>
                    </form>
                HTML;
        
        echo $output; 
    }
}
?>