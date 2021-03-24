<?php declare(strict_types=1);
/*
    Purpose: Demo9 - Class to check if a user has been authenticated
    Author: LV
    Date: March 2021
 */

class d9RWSAuthCheck
{
    static function isAuthenticated(string $aRedirect) : void
    {
        if (!isset($_SESSION['userInfo']))
        {
            header('location: d9SignIn.php?redirect=' . $aRedirect);
            die();
        }
    }
}
?>
