<?php

/*
$dsn = "sqlsrv:Server=mssql.iproject.icasites.nl,1433;Database=iproject3";

try

{

    $conn = new PDO($dsn, "iproject3", "QNxaK62B");

    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = "SELECT * FROM Voorwerp";

    foreach ($conn->query($sql) as $row)

    {

        print_r($row);

    }

    print_r('Done');

}

catch(PDOException $e)

{

    print_r($e->getMessage());

}

?>


*/

$hostname = "mssql.iproject.icasites.nl,1433";
$dbname = "iproject3";
$username = "iproject3";
$pw= "QNxaK62B";
$connection=NULL;

try {

    $connection = new PDO ("sqlsrv:server=$hostname;database=$dbname;ConnectionPooling=0;", "$username", "$pw");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::SQLSRV_ATTR_DIRECT_QUERY, true);
    $connection->setAttribute(PDO::SQLSRV_ENCODING_UTF8);

    } catch (PDOException $exception){
        echo "Error connecting to SQL database <br>";
        echo "following errors occured:<br>";
        echo $exception->getMessage();
        echo "<h1>Please contact your system administrator for further assistance</h1>";
        exit();
}






