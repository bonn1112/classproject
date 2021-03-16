<?php declare(strict_types=1);
/* 
    Purpose: Demo 9 - Class for creating a cookie
    Author: LV
    Date: March 2021
*/

class d9RWSCookie
{
    // method to create cookies
    
    function setSearchCookie(string $aString) : void
    {
        // cookies are set to expire 30 days from now (given in seconds)

        $expire = time() + (60 * 60 * 24 * 30);
        setcookie('lastsearch', $aString, $expire);
    }
}
?>