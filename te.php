<h3 style="border-bottom: #e5e5e5 solid 2px; padding: 5px; margin-bottom: 25px;" class="text-center">Upgrade uw
    account</h3>


<!-- Login form -->
<div class="panel panel-default col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4 center-block"
     id="loginPanel">
    <div class="panel-heading">
        Vul uw gegevens in
    </div>
    <div class="panel-body">
        <form action="BeheerLogin.php" method="POST">

            <!-- telefoonnummer input -->

            <div class="form-group">
                <div class="input-group">
                    <input name="telefoonnummer" type="text" class="form-control" placeholder="telefoonnummer"
                           required>
                    <div class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></div>
                </div>
            </div>

            <!-- banknaam input -->

            <div class="form-group">
                <div class="input-group">
                    <input name="banknaam" type="text" class="form-control" placeholder="banknaam" required>
                    <div class="input-group-addon"><i class="glyphicon glyphicon-home"></i></div>
                </div>
            </div>


            <!-- Rekeningnr input -->

            <div class="form-group">
                <div class="input-group">
                    <input name="rekeningnummer" type="text" class="form-control" placeholder="rekeningnummer"
                           required>
                    <div class="input-group-addon"><i class=" glyphicon glyphicon-euro"></i></div>
                </div>
            </div>


            <!-- creditcardnummer input -->

            <div class="form-group">
                <div class="input-group">
                    <input name="creditcardnummer" type="text" class="form-control" placeholder="creditcardnummer"
                           required>
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


<!-- Login form -->
<div class="col-xs-10 col-sm-6  col-md-4  center-block" id="loginWrapper">
    <div class="panel panel-default" id="loginPanel">
        <div class="panel-heading">
            Controle
        </div>
        <div class="panel-body">
            <form action="BeheerLogin.php" method="POST">

                <!-- telefoonnummer input -->

                <div class="form-group">
                    <div class="input-group">
                        <input name="telefoonnummer" type="text" class="form-control" placeholder="telefoonnummer"
                               required>
                        <div class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></div>
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
</div>
