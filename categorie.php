<?php
include('PHP/connection.php');

$statement = "SELECT * FROM eenmaalandermaal.dbo.Rubriek";
$results = $connection->query("SELECT RB_Naam FROM eenmaalandermaal.dbo.Rubriek WHERE RB_Parent = 0")->fetchAll(PDO::FETCH_COLUMN[1]);
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Categorieën</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">

    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <!--<link rel="stylesheet" href="CSS/BootstrapXL.css">-->

</head>

<body>

<!-- Navigation -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">
            <img src="Images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <form class="navbar-form navbar-left">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="zoeken">
            </div>
            <button type="submit" class="btn btn-default hidden-sm hidden-xs"><i class="glyphicon glyphicon-search"></i>
            </button>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#AdvancedSearch"><i
                        class="glyphicon glyphicon-menu-down"></i></button>
        </form>

        <div class="pull-right">
            <ul class="nav navbar-nav collapse navbar-collapse">
                <li>
                    <button class="btn btn-default navbar-btn hidden-md hidden-lg" data-toggle="collapse"
                            data-target="#MobileButtons"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
                </li>
                <li>
                    <button class="btn btn-primary navbar-btn hidden-sm hidden-xs">Plaats veiling</button>
                </li>
                <li>
                    <button class="btn btn-default navbar-btn hidden-sm hidden-xs NavRightButton"><i
                                class="glyphicon glyphicon-user"></i></button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Advanced Search -->

<div class="container-fluid collapse" id="AdvancedSearch">
    <div class="col-xs-12">
        <h1>Zoek hier!</h1>

    </div>
</div>


<!-- Mobile Buttons -->

<div class="container-fluid collapse text-center" id="MobileButtons" style="font-size: 24px;">
    <div class="row">
        <ul class="nav nav-pills nav-stacked bg-info lead">
            <li><a class="row-md-12" href="#">Plaats veiling</a></li>
            <li><a class="row-md-12" href="#">Login</a></li>
        </ul>
    </div>
</div>

<!-- Category Navigation -->

<?php
echo('<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">');
foreach ($results as $group) {
    echo('<div class="panel panel-default">');
    echo('<div class="panel-heading" role="tab" id="heading' . $group[0] . '">');
    echo('<h4 class="panel-title">');
    echo('<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $group[0] .'"
                   aria-expanded="true" aria-controls="collapse' . $group[0] .'">');
    echo($group[0]);
    echo('</a>');
    echo('</h4>');
    echo('</div>');
    echo('</div>');
}

?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingAutos">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAutos"
                   aria-expanded="true" aria-controls="collapseAutos">
                    Auto's
                </a>
            </h4>
        </div>
        <div id="collapseAutos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAutos">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingUitlaten">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#collapseAutos"
                               href="#collapseUitlaten"
                               aria-expanded="true" aria-controls="collapse">
                                Uitlaten
                            </a>
                        </h4>
                    </div>
                    <div id="collapseUitlaten" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingUitlaten">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingBMW">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#collapseUitlaten"
                                           href="#collapse"
                                           aria-expanded="true" aria-controls="collapse">
                                            BMW
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingAutos">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAutos"
                   aria-expanded="true" aria-controls="collapseAutos">
                    Auto's
                </a>
            </h4>
        </div>
        <div id="collapseAutos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAutos">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingUitlaten">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#collapseAutos"
                               href="#collapseUitlaten"
                               aria-expanded="true" aria-controls="collapse">
                                Uitlaten
                            </a>
                        </h4>
                    </div>
                    <div id="collapseUitlaten" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingUitlaten">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingBMW">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#collapseUitlaten"
                                           href="#collapse"
                                           aria-expanded="true" aria-controls="collapse">
                                            BMW
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>