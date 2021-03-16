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
                                <h2>Rockwell Studios - $pageTitle </h2>
                            </header>
                            
                            <nav>
                                <ul>
                                    <li><a href="d10Home.php">Home</a></li>
                                    <li><a href="d10Search.php">Search Spa</a></li>
                                    <li><a href="d10MyReviews.php">My Reviews</a></li>
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
                  &copy; $year Rockwell Studios
               </address>
            </footer>   
          </body>
         </html>
         ABC;
        echo $output;
    }
    
    function displaySearchForm (string $aTitle, string $aPitch, int $aRatingPK) : void
    {
        $output = <<<HTML
                    <form action="d10Search.php" method = "post" name="SearchByMultiCriteria" id="SearchByMultiCriteria">
                    <label for="spaname">spa Title:</label>
                    <input type="text" name="spaname" id="spaname" maxlength="50" value="$aTitle" />
                    <label for="pitchtext">Tag Line:</label>
                    <input type="text" name="pitchtext" id="pitchtext" maxlength="50" value="$aPitch" />
                    <label for="rating">spa Rating:</label>
                    <select name="ratingpk" id="rating">
                    <option value=""></option>
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
                HTML;
        
        $spaNum = 0;
        
        foreach ($aResults as $aspa)
        {
            extract($aspa);
            $spaNum ++;
            $spapk = urlencode(trim($spapk));
            $dateReleased = date_format(new DateTime($dateintheaters), "F j, Y");
        
            $output .= <<<HTML
                        <tr>
                            <td>$spaNum: $spaname<br />
                                $pitchtext
                            </td>
                            <td>
                                $dateReleased <br />
                                <a href="d10Reviews.php?spapk=$spapk">View Reviews</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            $summary
                            </td>
                        </tr>
                    HTML;
            }
    
        $output .= "<tbody></table>";
    
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
                $reviewpk = urlencode(trim($reviewpk));
                $reviewdate = date_format(new DateTime($reviewdate), "F j, Y");

                $output .= <<<HTML
                            <tr>
                                <td colspan="3">
                                    $reviewsummary
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    $reviewrating Reels
                                </td>
                                <td>
                                    Review Date: $reviewdate
                                </td>
                                <td>
                                    Reviewer: $firstname $lastname
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
                            <a href="d10AddEditreview.php?spapk=$aPK">[Review spa]</a> 
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
                                    $reviewsummary
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    $reviewrating Reels
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
                            autofocus required="true" pattern="^[a-zA-Z][a-zA-Z\s,]*[a-zA-Z\?\.]$" 
                            title="Review summary has invalid characters" /><br /><br />
                        <label for="reviewrating" id="rr">Review Rating (1 to 10 Reels):</label>
                        <select name="reviewrating" id="reviewrating">
                HTML;
        
        foreach (range(1,10) as $aRating)
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
                        <label for="country">Country:</label>
                        <input type="text" name="country" id ="country" value="$country" maxlength="20" 
                            class="twenty" required="true" pattern="^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$" 
                            title="Country has invalid characters" />     
                        <label for="email">Email:</label>
                        <input type="text" name="email" id ="email" value="$email" maxlength="50" 
                            class="twenty" required="true" pattern="^[\w\-\.]+@[\w]+\.[a-zA-Z]{2,4}$" 
                            title="Enter a valid email" /> 
                        <label for="phone">Telephone:</label>
                        <input type="text" name="phone" id ="phone" value="$phone" maxlength="12" 
                            class="ten" required="true" pattern="^(\d{3}-)?\d{3}-\d{4}$" 
                                title="Enter a valid phone number" />
                        <label for="mailinglist">Join mailing list?</label>
                        <input type="checkbox" name="mailinglist" id="mailinglist" $checked /> 
                        <p>
                            <input type="submit" value="Register" name="register" /> <br />
                        </p>
                    </form>
                HTML;
        
        echo $output; 
    }
}
?>