<?php declare(strict_types=1);
/* 
    Purpose: Demo 9 - Class for accessing and updating data in the RW Studios DB
    Author: LV
    Date: March 2021
 */
    
class d9RWSModel
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

            do
            {
                if ($stmt->columnCount() > 0)  // if rows with columns are returned
                {
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
                }
            } while ($stmt->nextRowset());
            
            // Note: the loop is intended for situations when a nonquery (e.g., Insert, Update) is followed by a query that                 returns row(s). 
           
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
        
    // method to return user data
    
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
    
    function getMerchandiseByName(string $aMerchandiseName) : array
    {
        $query = <<<STR
                    Select merchandisepk, merchandisename, merchandiseprice, imagenamesmall
                    From merchandise
                    Where merchandisename like '%$aMerchandiseName%'
                STR;

        return self::executeQuery($query);
    }

    function getMerchandiseDetailsByPK(int $aMerchandisePK) : array
    {
        $query = <<<STR
                    Select merchandisepk, merchandisename, merchandisedescription, 
                        merchandiseprice, imagenamelarge, movietitle
                    From merchandise inner join film on filmfk = filmpk
                    Where merchandisepk = $aMerchandisePK
            STR;

        return self::executeQuery($query);
    }

    function getMerchandiseInCart(string $merchandisePKs) : array
    {
        $query = <<<STR
                    Select merchandisepk, merchandisename, merchandiseprice
                    From merchandise
                    Where merchandisepk in ($merchandisePKs)
                STR;

        return self::executeQuery($query);
    }
    
    function insertOrder(int $aContactFK): array
    {
        $query = <<<STR
                    Insert into merchandiseorder(contactfk)
                    Values ($aContactFK);
                    Select SCOPE_IDENTITY() As newOrderID;
                STR;

        return self::executeQuery($query);
    }

    function insertOrderItem(int $aMerchandiseOrderFK, int $aMerchandiseFK, int $aOrderQty) : void
    {
            $query = <<<STR
                        Insert into merchandiseorderitem(merchandiseorderfk, merchandisefk, orderqty)
                        Values ($aMerchandiseOrderFK, $aMerchandiseFK, $aOrderQty)
                    STR;

        self::executeQuery($query);
    }
}
?>