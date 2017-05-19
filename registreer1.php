<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');


function checkEmailSent()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            // If already in DB

            // Send to DB



        /*    $code = 'testvanuitPHP';
            SendToDatabase(SetRegistratie($email, $code));

            mail($email, 'Subject', 'Message', 'From: info@iproject3.icasites.nl');
            echo '<div class="alert alert-success">
                  <strong>Success!</strong>Er is een verificatiecode verzonden naar ' . $email . '!</div>';
        */
        }
    }
}

function getEmail()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            echo $email;

        }
    }
}

?>

<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verifieer Emailadres</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="I-Project - Groep 3">

    <!-- Theme colors mobile -->
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#F6D155">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#F6D155">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#F6D155">

    <!-- setting browser icon -->
    <link rel="icon" href="images/Site-logo.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/HomePage.css">
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">

</head>

<body>

<!-- Navigation -->
<?php
require('navbar.html');
?>

<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Registreren - Stap 1</li>
</ol>

<div class="container">
    <div class="panel panel-default col-md-6 col-md-push-3">
        <div class="panel-body">

            <div class="row text-center">
                <div class="col-md-6 col-md-push-3">
                    <h2>Email verificatie</h2>
                    <h3>Na het verifiëren van uw emailadres kunt u zich registreren!</h3>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 col-md-push-3">

                    <?php
                    checkEmailSent();
                    ?>

                    <form method="POST" id="emailverificatie" action="registreer1.php">

                        <div class="form-group">
                            <label for="email">E-mailadres*</label>
                            <input name="email" id="email" type="email" placeholder="E-mailadres"
                                   value="<?php getEmail(); ?>"
                                   class="form-control" required="true">
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-push-3 text-center">
                                <button type="submit" class="btn btn-primary">Verstuur!</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <form method="POST" id="codeverificatie" action="registreer.php">

                        <div class="form-group">
                            <label for="code">Verificatiecode*</label>
                            <input name="code" id="code" type="text" placeholder="Verificatiecode"
                                   class="form-control" required="true">
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-push-3 text-center">
                                <button type="submit" class="btn btn-primary">Verifieer!</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>