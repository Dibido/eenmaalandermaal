<?php


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






