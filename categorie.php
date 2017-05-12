<?php
require('PHP/connection.php');

//Read all categories from the database
//$query = "SELECT * FROM Rubriek";
/*$query = "SELECT H.RB_Naam, X.RB_Naam
FROM Rubriek H 
CROSS APPLY 
( 
SELECT * FROM RUBRIEK S WHERE S.RB_Parent = H.RB_Nummer 
) X
WHERE H.RB_Parent = 0
ORDER BY H.RB_volgnummer,H.RB_Naam
";*/

$query = "SELECT H.RB_Naam, X.RB_Naam 
FROM Rubriek H
CROSS APPLY
(
  SELECT * FROM Rubriek S
  WHERE S.RB_Parent = H.RB_Nummer
) X

WHERE H.RB_Parent = 0
ORDER BY H.RB_Naam";


$groups = $connection->query($query)->fetchAll(PDO::FETCH_BOTH);

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
<a href="#A">a</a>
<a href="#B">b</a>
<a href="#C">c</a>
<a href="#D">d</a>
<a href="#E">e</a>
<a href="#F">f</a>
<a href="#G">g</a>
<a href="#H">h</a>
<div class="container">
    <?php
    $currentgroup = '';
    $eerstekeer = true;
    echo('<div class="row well">');
    foreach ($groups as $group) {

        if ($group[0] != $currentgroup) {
            if(!$eerstekeer){
                echo('</div>');
            }
            $currentgroup = $group[0];
            echo('<div class="col-xs-6 col-sm-5 col-md-3 col-xs-push-1 col-sm-push-2 col-md-push-0 col-lg-push-1">');
            echo('<h4>' . $group[0] . '</h4>');
            echo('<section id="'. $group[0][0] . '"></section>');
        }
        $eerstekeer = false;
        echo('<h6>' . $group[1] . '</h6>');
    }


    /*//loop through the groups
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
    }*/
    ?>
</div>
</body>
</html>