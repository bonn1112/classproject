<?php declare(strict_types=1);
/* 
    Purpose: Demo 9 - Class for getting data for and displaying data from RW Studios DB
    Author: LV
    Date: March 2021
    Uses: d9StylesRWS.css
*/

// automatically loads required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

class d9RWSDisplay
{
    // method to display page header
    
    function displayPageHeader(string $pageTitle)
    {
        $output = <<<ABC
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <meta charset="UTF-8" />
                            <title>Rockwell Studios</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1" />  
                            <link rel="stylesheet" href="d9StylesRWS.css" type="text/css" />
                        </head>

                        <body>
                            <header>
                                <h2>Rockwell Studios - $pageTitle </h2>
                            </header>
                            <section>
                ABC;
        
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
    
    function displaySearchForm(string $aName) : void
    {
        $output = <<<HTML
                    <div>
                        <a href="d9Viewcart.php">View Cart</a>
                    </div>
                    <form action="d9ShopSearch.php" method = "post">
                        <h2 style="text-align: center">Rockwell Studios Store</h2>
                        <label for="merchandisename">Merchandise:</label>
                        <input type="text" name="merchandisename" id ="merchandisename" maxlength="50" 
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
        
        if ($count == 0)
        {
            echo "<h3>No matching products found</h3>";
            return;
        }
               
        $counter = 0;

        $output = <<<HTML
                    <table id="merchandise">
                    <tr>
                HTML;

        foreach ($aResults as $aResult) 
        {
            extract($aResult);
            $merchandiseprice = number_format((float)$merchandiseprice,2,'.',',');
        
            $output .= <<<HTML
                        <td>
                    HTML;
            
            if ($imagenamesmall != '') 
            {
                $output .= <<<HTML
                            <img src="images/$imagenamesmall"><br />
                        HTML;
            }
        
            $output .= <<<HTML
                        <strong> <a href="d9ShopDetail.php?merchandisepk=$merchandisepk">$merchandisename</a> 
                            <strong> <br />
                        <i> \$$merchandiseprice </i> <br />
                        </td>
                    HTML;
            
            $counter ++;

            if ($counter === $count) 
            {
                $output .= <<<HTML
                            </tr> </table>
                        HTML;
            }
            elseif ($counter % 2 == 0) 
            {
                $output .= <<<HTML
                            </tr><tr>
                        HTML;
            }
        }

        echo $output;
    }
    
    function displayMerchandiseDetails(array $aList) : void
    {
        // extract the elements of the array

        extract($aList[0]);

        // format the price field

        $formattedPrice = number_format((float)$merchandiseprice, 2,'.',',');

        $output = <<<HTML
                    <div>
                        <a href="d9ViewCart.php">View Cart</a>
                    </div>
                    <h2 style="text-align: center">$merchandisename</h2>
                    <form action="d9UpdateCart.php" method = "post">
                    <input type="hidden" name="merchandisepk" value =$merchandisepk />
                 HTML;

        // include img tag if an image exists for the film

        if ($imagenamelarge !='')
        {
            $output .= <<<HTML
                        <div style="text-align:center">
                            <img src = "images/$imagenamelarge" />
                        </div>
                    HTML;
        }

        $output .= <<<HTML
                        <dl>
                            <dt>Description:</dt>
                                <dd>$merchandisedescription</dd>
                            <dt>Price:</dt>
                                <dd>\$$formattedPrice</dd>
                            <dt>From the film:</dt>
                                <dd>$movietitle</dd> <br />
                            <dt><input name = "submit" type="submit" value="Add to Cart" /></dt>
                        </dl>

                        <p>
                            <a href="d9ShopSearch.php">[Back to Search Page]</a>
                        </p>
                        </form>
               HTML;

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
                            <th>Product</th>
                            <th>Quantity</th>
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
                                <form action="d9Checkout.php" method="post">
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
                            <th>Product</th>
                            <th>Quantity</th>
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
    
    function displaySignInForm (string $aUserLogin, string $aUserPassword, string $aRedirect) : void
    {
        $output = <<<HTML
                    <form action="d9SignIn.php" name="signInForm" id="signInForm" method="post">
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
                    </p>
                    </form>
                HTML;
                
        echo $output;
    }
}
?>