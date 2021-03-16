<?php declare(strict_types=1);
/*
    Purpose: Demo9 - Shopping Cart
    Author: LV
    Date: March 2021
    Uses: d9RWSShopCart
 */

// automatically load required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

session_start();

// if the form element merchandisepk is set

if (isset($_POST['merchandisepk']))
{
    // if the session element aCart is not set

    if (!isset($_SESSION['aCart']))
    {
        // instantiate a d9RWSShopCart object and store it in $_SESSION

        $_SESSION['aCart'] = new d9RWSShopCart();
    }
    
    // if the form element merchandiseqty is set (if the user updates the quanity for a product in their shopping cart)

    if (isset($_POST['merchandiseqty']))
    {
        // call the updateCartItem method

       $_SESSION['aCart']->updateCartItem((int)$_POST['merchandisepk'],(int)$_POST['merchandiseqty']);
    }
    else
    {
        // call the addCartItem method
        
        $_SESSION['aCart']->addCartItem((int)$_POST['merchandisepk']);
    }
}
header('location:d9ViewCart.php');
exit();
?>
