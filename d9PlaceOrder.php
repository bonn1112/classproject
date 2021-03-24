<?php declare(strict_types=1);
/*
    Purpose: Demo9 - Shopping Cart
    Author: LV
    Date: March 2021
    Uses: d9RWSDisplay, d9RWSModel, d9RWSShopCart, d9RWSAuthCheck
 */
// automatically load required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

session_start();

// if the session variable is not set or is empty display appropriate message; otherwise display the items

if (!isset($_SESSION['aCart']) || count($_SESSION['aCart']->getCartItems()) === 0)
{
    header('Refresh: 5; URL=d9ShopSearch.php');
    echo '<h2>You shopping cart is empty <br /> You will be redirected to our store in 5 seconds.</h2>';
    echo '<h2>If you are not redirected, please <a href="d9ShopSearch.php">Click here to visit our Store</a>.</h2>';
    die();
}

// call the static method in d9RWSAuthCheck to check if the user is authenticated

d9RWSAuthCheck::isAuthenticated($_SERVER['PHP_SELF']); // get the file name of this page from $_SERVER array

// instantiate a d9RWSModel object

$aModel = new d9RWSModel();

// call the insertOrder method; get the orderPK of the newly added order

$orderIDResult = $aModel->insertOrder((int)$_SESSION['userInfo']['contactpk']);

$newOrderID = $orderIDResult[0]['newOrderID'];

// for each item in the shopping cart, 
// insert a row into the merchandiseorderitems table

foreach($_SESSION['aCart']->getCartItems() as $aKey => $aValue)
{
    $aModel->insertOrderItem((int)$newOrderID, $aKey, $aValue);

    // delete the item from the cart
    
    $_SESSION['aCart']->deleteCartItem($aKey);
}

// instantiate a d9RWSDisplay object

$aDisplay = new d9RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Order Confirmation");

$output = <<<ABC
            <h2 style="text-align: center">Thank you for your order</h2>
            <p style="text-align: center">
                <a href="d9ShopSearch.php">[Back to our store]</a>
            </p>
        ABC;

// display the output

echo $output;

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>
