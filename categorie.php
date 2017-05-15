<?php
require('PHP/connection-old.php');
require('PHP/Functions.php');

//Read all categories from the database
$query = "SELECT
  H.RB_Naam AS Hoofd_Naam,
  H.RB_Nummer AS Hoofd_Nummer,
  S.RB_Naam AS Sub_Naam,
  S.RB_Nummer AS Sub_Nummer
FROM Rubriek H
  CROSS APPLY
  (
    SELECT *
    FROM Rubriek S
    WHERE S.RB_Parent = H.RB_Nummer
  ) S
WHERE H.RB_Parent = 0
ORDER BY H.RB_volgnummer, H.RB_Naam, H.RB_Nummer";

try {
    $groups = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo('<h1>De categorieen konden niet opgehaald worden</h1>');
    echo('<p>Error: ' . $e->getMessage() . '</p>');
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
    <link rel="stylesheet" href="CSS/HomePage.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/categorie.css">

</head>

<body>

<!-- Navigation -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">
            <img src="images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav collapse navbar-collapse">
                <li>
                    <button class="btn btn-default navbar-btn hidden-md hidden-lg MobileButtonToggle" data-toggle="collapse"
                            data-target="#MobileButtons"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
                </li>
                <li>
                    <button class="btn btn-primary navbar-btn hidden-sm hidden-xsv NavLeftButton">Plaats veiling</button>
                </li>
                <li>
                    <button class="btn btn-default navbar-btn hidden-sm hidden-xs NavRightButton"><i
                                class="glyphicon glyphicon-user"></i></button>
                </li>
            </ul>
        </div>

        <form class="navbar-form" action="resultaten.php" method="GET">
            <div class="form-group" style="display:inline;">
                <div class="input-group" style="display:table;">
                    <input class="form-control" name="search" placeholder="Search Here" autocomplete="off" autofocus="autofocus" type="text">
                    <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button class="btn btn-secondary" type="submit" style="background-color: #ffffff; border-color: #f2f2f2;"><span class="glyphicon glyphicon-search"></span></button></span>
                </div>
            </div>
        </form>

    </div>
</nav>

<!-- Mobile Buttons -->

<div class="container-fluid collapse text-center" id="MobileButtons" style="font-size: 24px;">
    <div class="row">
        <ul class="nav nav-pills nav-stacked bg-info lead">
            <li><a class="row-md-12" href="#">Plaats veiling</a></li>
            <li><a class="row-md-12" href="categorie.php">Alle Categoriën</a></li>
            <li><a class="row-md-12" href="#">Login</a></li>
        </ul>
    </div>
</div>

<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Categorieën</li>
</ol>

<!-- Letter search -->
<div class="letter-search text-center well well-sm">
    <?php
    laadLetters();
    ?>
</div>

<!-- Category Navigation -->

<div class="container">
    <?php
    if (isset($groups)) {
        $currentgroup = '';
        $eerstekeer = true;
        echo('<div class="row well">');
        foreach ($groups as $group) {
            if ($group['Hoofd_Naam'] != $currentgroup) {
                if (!$eerstekeer) {
                    echo('</div>');
                }
                $currentgroup = $group['Hoofd_Naam'];
                $url = urlencode($group['Hoofd_Nummer']);
                echo('<div class="col-xs-6 col-sm-5 col-md-4 col-xs-push-1 col-sm-push-2 col-md-push-0 col-lg-push-1">');
                echo('<section id="' . $group['Hoofd_Naam'][0] . '">');
                echo('<a href="resultaten.php?category=' . $url . '"><h4>' . $group['Hoofd_Naam'] . '</h4></a>');
                echo('</section>');
            }
            $eerstekeer = false;
            $url = urlencode($group['Sub_Nummer']);
            echo('<a href="resultaten.php?category=' . $url . '"><h6>' . $group['Sub_Naam'] . '</h6></a>');
        }
    }
    echo('</div>');
    ?>
</div>

<!-- Letter search bottom -->
<div class="text-center well well-sm">
    <?php
    laadLetters();
    ?>
</div>
</body>
</html>
