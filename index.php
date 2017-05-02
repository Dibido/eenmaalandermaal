<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Bootstrap test</title>
    <meta name="description" content="Bootstrap testsite">
    <meta name="author" content="Nathan">



    <!-- Bootstrap -->
    <!--link rel="stylesheet" href="css/bootstrap-grid.css" -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <!-- CSS -->
    <link rel="stylesheet" href="css/Main.css">

</head>

<body>




<?php


$hostname = "192.168.122.222";
$dbname = "eenmaalandermaal";
$username = "sa";
$pw= "1q2w3e4r";
$connection=NULL;

try {
    $connection = new PDO ("sqlsrv:server=$hostname;database=$dbname;ConnectionPooling=0", "$username", "$pw");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::SQLSRV_ATTR_DIRECT_QUERY, true);

    echo "<h1>succes!</h1>";

} catch (PDOException $exception){
    echo "Error connecting to SQL database <br>";
    echo "following errors occured:<br>";
    echo $exception->getMessage();
    echo "<h1>Please contact your system administrator for further assistance</h1>";
    exit();
}
?>




</body>

</html>