<?php
require('PHP/connection.php');

//Read all categories from the database
$query = "SELECT * FROM Rubriek";
$groups = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <link rel="stylesheet" href="CSS/categorie.css">

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

<!-- Mobile Buttons -->

<div class="container-fluid collapse text-center" id="MobileButtons" style="font-size: 24px;">
    <div class="row">
        <ul class="nav nav-pills nav-stacked bg-info lead">
            <li><a class="row-md-12" href="#">Plaats veiling</a></li>
            <li><a class="row-md-12" href="#">Login</a></li>
        </ul>
    </div>
</div>

<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Categorieën</li>
</ol>

<!-- Category Navigation -->
<div class="container">
    <?php
    echo('<div class="well well-sm">');
    //loop through the groups
    for ($i = 1; $i < sizeof($groups); $i++) {
        //don't use root (index 0)
        if ($groups[$i]['RB_Parent'] != 0) {
            $i = sizeof($groups);
        } else {
            //display parent
            $parenturl = urlencode($groups[$i]['RB_Naam']);
            echo('<div class="page-header">');
            echo('<a href="resultaten.php?categorie=' . $parenturl . '"><h4>' . $groups[$i]['RB_Naam'] . '</h4></a>');
            echo('</div>');
            $parentwaarde = $groups[$i]['RB_Nummer'];
            echo('<div class="categorie">');
            //loop through groups
            for ($j = 0; $j < sizeof($groups); $j++) {
                //find all children of selected parent
                if ($groups[$j]['RB_Parent'] == $parentwaarde) {
                    //display children
                    $childurl = urlencode($groups[$j]['RB_Naam']);
                    echo('<a href="resultaten.php?categorie=' . $childurl . '"><h6>' . $groups[$j]['RB_Naam'] . '</h6></a>');
                }
            }
            echo('</div>');
        }
    }
    ?>
</div>
</body>
</html>