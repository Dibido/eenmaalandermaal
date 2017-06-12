<?php
//This php script is used to connect to the SQL server using a require on every page.

$hostname = "mssql.iproject.icasites.nl,1433";
$dbname = "iproject3";
$username = "iproject3";
$pw= "QNxaK62B";
$connection=NULL;
try {
    $connection = new PDO ("sqlsrv:server=$hostname;database=$dbname;ConnectionPooling=0;", "$username", "$pw");
    //To throw exceptions by default.
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //To query without prepared statements.
    $connection->setAttribute(PDO::SQLSRV_ATTR_DIRECT_QUERY, true);
} catch (PDOException $exception){
    echo "Error connecting to SQL database <br>";
    echo "following errors occured:<br>";
    echo $exception->getMessage();
    echo "<h1>Please contact your system administrator for further assistance</h1>";
    exit();
}







