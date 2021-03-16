<?php declare(strict_types=1);
/*
    Purpose: Demo 10 - Class to check if a user has been authenticated
    Author: LV
    Date: March 2021
 */

session_start();

class d10RWSAuthCheck
{
    // this method checks if the user has been authenticated
    // if the session array element, "userInfo" is not set,
    // the user is redirected to the sign in page (d10SignIn.php)
    
    static function isAuthenticated(string $aRedirect) : void
    {
        if (!isset($_SESSION['userInfo']))
        {
            if (isset($_GET['filmpk']) && is_numeric($_GET['filmpk']))
            {
                $filmPK = (int) $_GET['filmpk'];
                $aRedirect .= '?filmpk=' . $filmPK;
            }
            header('location: d10SignIn.php?redirect=' . $aRedirect);
            die();
        }
    }
}

    


?>
