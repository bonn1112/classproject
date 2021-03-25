<?php declare(strict_types=1);
/* 
    Purpose: Demo 10 - Class for accessing and updating data in the RW Studios DB
    Author: LV
    Date: March 2021
 */
    
class d10RWSModel
{
    // static method to connect to the database

    private static function dbConnect() : object
    {
        $serverName = 'buscissql1901\cisweb';
        $uName = 'exposed';
        $pWord = 'source';
        $db = 'Team115DB';
    
        try
        {
            //instantiate a PDO object and set connection properties
        
            $conn = new PDO("sqlsrv:Server=$serverName; Database=$db", $uName, $pWord, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
           
        }
        // if connection fails
    
        catch (PDOException $e)
        {
            die('Connection failed: ' . $e->getMessage());
        }
    
        //return connection object

        return $conn;
    }

    // static method to execute a query - the SQL statement to be executed, is passed to it

    private static function executeQuery(string $query)
    {
        // call the dbConnect function

        $conn = self::dbConnect();

        try
        {
            // execute query and assign results to a PDOStatement object

            $stmt = $conn->query($query);

            if ($stmt->columnCount() > 0)  // if rows with columns are returned
            {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
            }

            //call dbDisconnect() method to close the connection

            self::dbDisconnect($conn);

            return $results;
        }
        catch (PDOException $e)
        {
            //if execution fails

            self::dbDisconnect($conn);
            die ('Query failed: ' . $e->getMessage());
        }
    }
    
    // static method to close the DB connection
    
    private static function dbDisconnect($conn) : void
    {
        // closes the specfied connection and releases associated resources

        $conn = null;
    }
        
    // return spa ratings
    
    function getspaRatings() : array
    {
        $query = <<<STR
                    Select ratingpk, rating
                    From sparating
                    Order by ratingpk
                 STR;
        
        return self::executeQuery($query);
    }
    
    // return spa rating for a ratingPK
    
    function getAspaRating(int $aPK) : array
    {
        $query = <<<STR
                    Select ratingpk, rating
                    From sparating
                    where ratingpk = $aPK
                STR;
        
        return self::executeQuery($query);
    }

    // search for spas by spaname, pitch text and/or rating
    
    function getspasByMultiCriteria(string $aTitle, string $aPitchText, int $aRatingPK) : Array
    {
        $query = <<<STR
                    Select *
                    From spa
                    Where 0=0
                STR;
        
        if ($aTitle != '')
        {
            $query .= <<<STR
                        And treatments like '%$aTitle%'
                    STR;
        }
        
        if ($aPitchText != '')
        {
            $query .= <<<STR
                        And hours like '%$aPitchText%'
                    STR;
        }
        
       
        $query .= <<<STR
                    Order by treatments
                STR;
        
        return self::executeQuery($query);
    }

    // return the spa name for a spapk
    
    function getAcourseName(int $aSpaPK) : array
    {
        $query = <<<STR
                    Select treatments
                    From spa
                    Where treatments_id = $aSpaPK
                STR;

        return self::executeQuery($query);
    }

    // return reviews for a spa
    
    function getSpaReviews(int $aSpaPK) : array
    {
        $query = <<<STR
                    Select *
                    From spareview left join contact on contactpk = contactfk
                    where spafk = $aSpaPK
                STR;

        return self::executeQuery($query);
    }
    
    // return reviews for a user
    
    function getUserReviews(int $aContactPK) : array
    {
        $query = <<<STR
                    Select reviewpk, reviewdate, reviewsummary, reviewrating, spaname
                    From spareview inner join spa on spapk = spafk
                    where contactfk = $aContactPK
                    Order by reviewdate desc
                STR;

        return self::executeQuery($query);
    }

    // return details for a review
    
    function getReviewDetails(int $aReviewPK, int $aContactFK) : array
    {
        $query = <<<STR
                    Select reviewsummary, reviewrating, spaname
                    From spareview inner join spa on  = spafk
                    where reviewpk = $aReviewPK and contactfk = $aContactFK
                STR;

        return self::executeQuery($query);
    }
    
    // return user data
    
    function getUserData(string $aUserName, string $aUserPassword) : array
    {
        $query = <<<STR
                    Select contactpk, firstname
                    From contact
                    Where userlogin = '$aUserName'
                    and userpassword = '$aUserPassword'
                STR;
        
        return self::executeQuery($query);
    }
    
    // check if username already exists
    
    function checkUserName(string $aUserName) : array
    {
        $query = <<<STR
                    Select userlogin
                    From contact
                    Where userlogin = '$aUserName'
                STR;

        return self::executeQuery($query);
    }
    
    // insert a new member
    
    function addNewMember(array $aMemberData) : void
    {
        // extract array data
        
        extract($aMemberData);
        
        $query = <<<STR
                    Insert Into contact(userlogin, userpassword, firstname, lastname, address, 
                        city, state, zip, email, phone)
                    Values('$userlogin','$userpassword','$firstname','$lastname','$address','$city',
                        '$state','$zip','$email','$phone')
            STR;
        
        self::executeQuery($query);
    }
    
    // insert a new review
    
    function addNewReview(string $aSummary, int $aRating, int $aspaFK, int $aContactFK) : void
    {
        $query = <<<STR
                    Insert Into spareview(reviewsummary,reviewrating,spafk,contactfk)
                    Values('$aSummary', $aRating, $aspaFK, $aContactFK)
                STR;
        
        self::executeQuery($query);
    }
    
    // update a review
    
    function updateReview(int $aReviewPK, string $aSummary, int $aRating) : void
    {
        $query = <<<STR
                    Update spareview
                    Set reviewsummary = '$aSummary', reviewrating = $aRating
                    Where reviewpk = $aReviewPK
                STR;
        
        self::executeQuery($query);
    }
    
    // delete a review
    
    function deleteReview(int $aReviewPK, int $aContactFK) : void
    {
        $query = <<<STR
                    delete
                    from spareview            
                    where reviewpk = $aReviewPK and contactfk = $aContactFK
                STR;
        
        self::executeQuery($query);
    }
}
?>