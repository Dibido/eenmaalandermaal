<?php
session_start();
require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

print_r($_SESSION);
print_r($_POST);


//redirect of no login
if(!isset($_SESSION["Username"]) OR empty($_SESSION["Username"])){
    header("Location: login.php?unauthorised=True");
}


// form validation
$errorMessage = [False];
$disabled = '';

foreach ($_POST as $itemId => $item){
    if(empty($item)){
        $errorMessage = [True, ' U heeft niet alle velden ingevuld.'];
    }else{
        $results[$itemId] = cleanInput($item);

        /* checking if the code is correct */


        /* Form handeling */
        $formSend = True;
        $successMessage = [True, ' Er is een code naar uw email verstuurd. Vul hem hier onder in om verder te gaan.'];
    }
}






?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>EenmaalAndermaal - Beste veilingssite van Nederland</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">


    <!-- Theme colours for mobile -->

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#F6D155">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#F6D155">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">


    <!-- setting the browser icon -->
    <link rel="icon" href="images/Site-logo.png">


    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/upgradeAccount.css">


</head>

<body>

<?php
include "navbar.php";
?>

<div class="container center-block">
    <div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
        <h3 style="border-bottom: #e5e5e5 solid 2px; padding: 5px; margin-bottom: 25px;" class="text-center">Upgrade uw account</h3>
        <div class="panel panel-default" >
            <div class="panel-heading text-center">Vul uw gegevens in</div>
            <div class="panel-body">

                <?php
                    /* checking if any alerts of success messages need to be displayed */
                    if ($errorMessage[0]) {

                        echo "<div class=\"alert alert-danger alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Error!</strong> " . $errorMessage[1] . "
                          </div>";

                    } else if ($successMessage[0]) {
                        echo "<div class=\"alert alert-success alert-dismissable\">
                             <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">×</a>
                             <strong>Success!</strong> " . $successMessage[1] . "
                          </div>";
                    }
                    ?>
            </div>
        </div>
    </div>
</div>

</body>
