<?php declare(strict_types=1);
/*
    Purpose: Demo9 - Shopping Cart
    Author: LV
    Date: March 2021
    Uses: d9RWSDisplay, d9RWSModel
 */
// automatically load required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

$listPage = 'd9ShopSearch.php';

// If merchandisepk is not passed with page request, redirect to Shop Search Page
// Else, assign the URL parameter to a variable

if (!isset($_GET['merchandisepk']) || !is_numeric($_GET['merchandisepk']))
{
    header('Location:' . $listPage);
    exit();
}
else
{
    $merchandisePK = (int) $_GET['merchandisepk'];
}

// instantiate a d9RWSModel object

$aModel = new d10RWSModel();

// Call the getMerchandiseDetailsByPK method

$merchList = $aModel->getMerchandiseDetailsByPK($merchandisePK);

// If the number of records is not 1, redirect to Store Search Page

if (count($merchList) != 1)
{
   header('Location:' . $listPage);
   exit();
}

// instantiate a d9RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Product Details");

// call the displayMerchandiseDetails method

$aDisplay->displayMerchandiseDetails($merchList);

// call the displayPageFooter method 

$aDisplay->displayPageFooter();
?>
