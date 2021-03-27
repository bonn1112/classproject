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

// get a list of merchandiseIDs for the cart items; string them together delimiting with a comma

$merchandiseIDs = implode(',', array_keys($_SESSION['aCart']->getCartItems()));

// instantiate a d9RWSModel object

$aModel = new d10RWSModel();

//get merchandise details for the items in the cart

$cartList = $aModel->getMerchandiseInCart($merchandiseIDs);

// instantiate a d9RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Place Order");

// call the displayCheckOut method

$aDisplay->displayCheckOut($cartList);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>
