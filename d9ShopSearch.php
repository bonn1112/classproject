<?php declare(strict_types=1);
/*
    Purpose: Demo9 - Shopping Cart
    Author: LV
    Date: March 2021
    Uses: d9RWSDisplay, d9RWSCookie, d9RWSModel
 */
// automatically load required Class files

spl_autoload_register(function ($class_name){
    include $class_name . '.php';
});

// if the form is submitted

if (isset($_POST['search'])) 
{
    $merchandiseName =  trim($_POST['merchandisename']);
    
    // instantiate a d9RWSCookie object
    
    $aCookie = new d9RWSCookie();
    
    // call the setSearchCookie method
    
    $aCookie->setSearchCookie($merchandiseName);
}

// If a previous user is visting this page

elseif (isset($_COOKIE['lastsearch'])) 
{
    $merchandiseName =  $_COOKIE['lastsearch'];
}

// If a user is visiting this page for the first time

else 
{
    $merchandiseName =  '';
}

// instantiate a d9RWSDisplay object

$aDisplay = new d10RWSDisplay();

// call the displayPageHeader method

$aDisplay->displayPageHeader("Search our Product Catalog");

// call the displaySearchForm method

$aDisplay->displaySearchForm($merchandiseName);

// if a cookie exists or the user has initiated a search

if (isset($_POST['search']) || isset($_COOKIE['lastsearch']))
{
    // instantiate a d9RWSModel object

    $aModel = new d10RWSModel();
    
    $results = $aModel->getMerchandiseByName($merchandiseName);
    
    // call the displaySearchResults method

     $aDisplay->displaySearchResults($results);
}

// call the displayPageFooter method 

$aDisplay->displayPageFooter();

?>