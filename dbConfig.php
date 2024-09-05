<?php
class DbConnection
{
    public function connect()
    {

        $host = 'sql203.infinityfree.com';
        $username = 'if0_37244580';
        $password = 'cM5ewTFPByJw';
        $db = 'if0_37244580_listify_db';

        try {

            $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Throwable $e) {
            echo "Connection error: " . $e->getMessage();
        }

    }
}


$dbConn = new DbConnection();