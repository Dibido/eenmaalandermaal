<?php
session_start();
require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

print_r($_SESSION);
print_r($_POST);


//redirect of no login
if (!isset($_SESSION["Username"]) OR empty($_SESSION["Username"])) {
    header("Location: login.php?unauthorised=True");
}


// form validation
$errorMessage = [False];
$disabled = '';

foreach ($_POST as $itemId => $item) {
    $item = trim($item);
    if (empty($item)) {
        $errorMessage = [True, ' U heeft niet alle velden ingevuld.'];
        $emptyItem = True;
    } else if(!$emptyItem) {
        $results[$itemId] = cleanInput($item);


        /* Form handeling */

        //checking the input for invalid values
        if (strlen($results["banknaam"]) <= 24) {
            if (strlen($results["rekeningnummer"]) <= 31) {
                if (strlen($results["creditcardnummer"]) <= 19) {

                    //creating a code for the user
                    createUpgradeCode($_SESSION["Username"]);

                    //updating the page to waiting for code state
                    $disabled = 'disabled';
                    $formSend = True;
                    $successMessage = [True, ' Er is een code naar uw email verstuurd. Vul hem hier onder in om verder te gaan.'];

                } else {
                    $errorMessage = [True, ' Uw creditcardnummer kan niet langer dan 19 characters zijn.'];
                }

            } else {
                $errorMessage = [True, 'Uw rekeningnummer kan niet langer dan 31 characters zijn.'];
            }

        } else {
            $errorMessage = [True, 'Uw banknaam kan niet langer dan 24 characters zijn.'];
        }

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

                <form <?php if($formSend){echo "action=upgradeAccount2.php";} ?> action="upgradeAccount.php" method="POST" id="mainForm">

                    <!-- banknaam input -->

                    <div class="form-group">
                        <div class="input-group">
                            <input <?php echo $disabled?> name="banknaam" type="text" class="form-control" placeholder="banknaam"
                                   required value="<?php echo $results["banknaam"]; ?>"  maxlength="24">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-home"></i></div>
                        </div>
                    </div>


                    <!-- Rekeningnr input -->

                    <div class="form-group">
                        <div class="input-group">
                            <input <?php echo $disabled?> name="rekeningnummer" type="text" class="form-control" placeholder="rekeningnummer"
                                   required value="<?php echo $results["rekeningnummer"]; ?>" maxlength="31">
                            <div class="input-group-addon"><i class=" glyphicon glyphicon-euro"></i></div>
                        </div>
                    </div>


                    <!-- creditcardnummer input -->

                    <div class="form-group">
                        <div class="input-group">
                            <input <?php echo $disabled?> name="creditcardnummer" type="text" class="form-control" placeholder="creditcardnummer"
                                   required value="<?php echo $results["creditcardnummer"]; ?>" maxlength="19">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></div>
                        </div>
                    </div>



                    <!-- Alerts -->

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
                </form>
            </div>
        </div>

        <div class="panel panel-default" >
            <div class="panel-heading text-center">Controle</div>
            <div class="panel-body">

                <!-- toelichting op controle -->

                <?php

                    if(!$formSend) {
                        echo "
                        <p>Wanneer een gebruiker zich wilt registreren als een verkoper, is het nodig om een extra controle te ondergaan.
                        Deze controle is mogelijk in de vorm van een brief, met een persoonlijke code. Of via een controle van uw creditcard.
                         Hieronder kunt u een van deze opties kiezen. </p>";
                    } else{
                        echo "
                        
                        <p>Hier onder kunt u uw verificatiecode invullen.</p>
                        
                        ";
                    }

                 ?>


                <!-- inut voor verificatiecode -->

                <?php

                    if($formSend){
                        echo" <div class=\"form-group\">
                            <div class=\"input-group\">
                                <input name=\"verificatiecode\" type=\"text\" class=\"form-control\" placeholder=\"verificatiecode\"
                                       required form='mainForm'>
                                <div class=\"input-group-addon\"><i class=\"glyphicon glyphicon-check\"></i></div>
                            </div>
                        </div>";
                    }



                ?>


                    <!-- Controle input -->

                <form class="form-inline">
                    <select class="form-control controleSelect" required form="mainForm" name="controleOptie" id="controleSelect">

                        <?php
                        if(!$formSend){
                            echo"
                                 <option value=\"\" disabled selected>Controle voor registratie</option>
                                 <option>Creditcard</option>
                                 <option>Post</option>";
                        }else{
                            echo "<option id=\"" . $disabled . "\" value=\"" . $results["controleOptie"] . "\" selected>" . $results["controleOptie"] . "</option>";
                        }

                        ?>

                    </select>

                    <!-- submit button -->

                    <button id="conroleButton" type="submit" class="btn btn-primary" form="mainForm" >Submit</button>

                </form>
            </div>
        </div>

    </div>
</body>

