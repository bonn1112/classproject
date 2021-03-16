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
        $uName = 'csu';
        $pWord = 'rams';
        $db = 'RWStudios';
    
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
        
    // return film ratings
    
    function getFilmRatings() : array
    {
        $query = <<<STR
                    Select ratingpk, rating
                    From filmrating
                    Order by ratingpk
                 STR;
        
        return self::executeQuery($query);
    }
    
    // return film rating for a ratingPK
    
    function getAFilmRating(int $aPK) : array
    {
        $query = <<<STR
                    Select ratingpk, rating
                    From filmrating
                    where ratingpk = $aPK
                STR;
        
        return self::executeQuery($query);
    }

    // search for films by movietitle, pitch text and/or rating
    
    function getFilmsByMultiCriteria(string $aTitle, string $aPitchText, int $aRatingPK) : Array
    {
        $query = <<<STR
                    Select filmpk, movietitle, pitchtext, summary, dateintheaters
                    From film
                    Where 0=0
                STR;
        
        if ($aTitle != '')
        {
            $query .= <<<STR
                        And movietitle like '%$aTitle%'
                    STR;
        }
        
        if ($aPitchText != '')
        {
            $query .= <<<STR
                        And pitchtext like '%$aPitchText%'
                    STR;
        }
        
        if ($aRatingPK != '')
        {
            $query .= <<<STR
                        And ratingfk = $aRatingPK
                    STR;
        }
    
        $query .= <<<STR
                    Order by movietitle
                STR;
        
        return self::executeQuery($query);
    }

    // return the movie title for a film
    
    function getAMovieTitle(int $aFilmPK) : array
    {
        $query = <<<STR
                    Select movietitle
                    From film
                    Where filmpk = $aFilmPK
                STR;

        return self::executeQuery($query);
    }

    // return reviews for a film
    
    function getMovieReviews(int $aFilmPK) : array
    {
        $query = <<<STR
                    Select reviewpk, reviewdate, reviewsummary, reviewrating, contactfk, 
                        firstname, lastname
                    From filmreview inner join contact on contactpk = contactfk
                    where filmfk = $aFilmPK
                STR;

        return self::executeQuery($query);
    }
    
    // return reviews for a user
    
    function getUserReviews(int $aContactPK) : array
    {
        $query = <<<STR
                    Select reviewpk, reviewdate, reviewsummary, reviewrating, movietitle
                    From filmreview inner join film on filmpk = filmfk
                    where contactfk = $aContactPK
                    Order by reviewdate desc
                STR;

        return self::executeQuery($query);
    }

    // return details for a review
    
    function getReviewDetails(int $aReviewPK, int $aContactFK) : array
    {
        $query = <<<STR
                    Select reviewsummary, reviewrating, movietitle
                    From filmreview inner join film on filmpk = filmfk
                    where reviewpk = $aReviewPK and contactfk = $aContactFK
                STR;

        return self::executeQuery($query);
    }
    
    // return user data
    
    function getUserData(string $aUserName, string $aUserPassword) : array
    {
        $query = <<<STR
                    Select contactpk, firstname, userrolename
                    From contact inner join userrole
                    on userrolefk = userrolepk
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
                        city, state, zip, country, email, phone, mailinglist)
                    Values('$userlogin','$userpassword','$firstname','$lastname','$address','$city',
                        '$state','$zip','$country','$email','$phone','$mailinglist')
            STR;
        
        self::executeQuery($query);
    }
    
    // insert a new review
    
    function addNewReview(string $aSummary, int $aRating, int $aFilmFK, int $aContactFK) : void
    {
        $query = <<<STR
                    Insert Into filmreview(reviewsummary,reviewrating,filmfk,contactfk)
                    Values('$aSummary', $aRating, $aFilmFK, $aContactFK)
                STR;
        
        self::executeQuery($query);
    }
    
    // update a review
    
    function updateReview(int $aReviewPK, string $aSummary, int $aRating) : void
    {
        $query = <<<STR
                    Update filmreview
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
                    from filmreview            
                    where reviewpk = $aReviewPK and contactfk = $aContactFK
                STR;
        
        self::executeQuery($query);
    }
}
?>