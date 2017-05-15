<?php
require 'PHP/connection.php';
require 'PHP/Functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['zoekterm'])) {
        $zoekterm = ($_GET['zoekterm']);
    }
    if (isset($_GET['sorteerfilter'])) {
        $sorteerfilter = urldecode($_GET['sorteerfilter']);
    }
    if (isset($_GET['betalingsmethode'])) {
        $betalingsmethode = $_GET['betalingsmethode'];
    }
    if (isset($_GET['prijs'])){
        $prijs = explode(',',$_GET['prijs']);
    }
    if (!empty($zoekterm)) {
        //bouwen query
        $sql = "SELECT  *
                        FROM Voorwerp v 
                        LEFT JOIN Bod b ON v.VW_voorwerpnummer = b.BOD_voorwerpnummer 
                        WHERE (B.BOD_bodbedrag = (SELECT TOP 1 BOD_Bodbedrag 
                        FROM Bod 
                        WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag 
                        FROM Bod WHERE BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) OR b.BOD_bodbedrag IS NULL) 
                        AND VW_titel LIKE '%$zoekterm%'";
        $searchresult = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    $sql = "SELECT BW_betalingswijze AS Betalingswijze FROM Betalingswijzen";
    $betalingswijzenresult = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/*

$titel = $row['VW_titel'];
$beschrijving = $row['VW_beschrijving'];
$bodBedrag = $row['BOD_bodbedrag'];
$tijd = $row['VW_looptijdEinde'] - $row['VW_looptijdStart'];


echo "<div class=\"item  col-xs-4 col-lg-4\">
<div class=\"veiling thumbnail\">
<div class=\"veiling-titel label label-info\">
    {$row['VW_titel']}
</div>
<div class=\"veiling-image\" style=\"background-image:url(images/16-9.jpeg)\"></div>
<p>{$row['VW_beschrijving']}</p>
<div class=\"veiling-prijs-tijd\">
    <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\">
                       {$row['BOD_bodbedrag']}
    </i>
    </div>
    <div class=\"tijd label label-default\"> $tijd <i class=\"glyphicon glyphicon-time\"></i></div>
</div>
<div class=\"veiling-rating-bied label label-default\">
    <div class=\"rating text-center\">
        <i class=\"glyphicon glyphicon-star\"></i>
        <i class=\"glyphicon glyphicon-star\"></i>
        <i class=\"glyphicon glyphicon-star\"></i>
        <i class=\"glyphicon glyphicon-star\"></i>
        <i class=\"glyphicon glyphicon-star-empty\"></i>
    </div>
    <button class=\"btn btn-primary bied\">Bied Nu!</button>
</div>
</div>
</div>";
*/
?>

<!doctype html>


<html lang="en">
<meta charset="utf-8">

<head>

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
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/resultaten.css">

    <!-- CSS voor price slider -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/css/bootstrap-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/bootstrap-slider.js"></script>

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
                    <button class="btn btn-default navbar-btn hidden-md hidden-lg MobileButtonToggle"
                            data-toggle="collapse"
                            data-target="#MobileButtons"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
                </li>
                <li>
                    <button class="btn btn-primary navbar-btn hidden-sm hidden-xsv NavLeftButton">Plaats veiling
                    </button>
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
                    <input class="form-control" name="zoekterm" placeholder="Search Here" autocomplete="off"
                           autofocus="autofocus" type="text" value="<?php if (!empty($zoekterm)) {
                        echo($zoekterm);
                    } ?>">
                    <span class="input-group-addon" style="width:1%;"><span
                                class="glyphicon glyphicon-search"></span></span>
                </div>
            </div>
        </form>

    </div>
</nav>
<!-- Mobile Buttons -->

<div class="container-fluid collapse text-center" id="MobileButtons" style="font-size: 24px;">
    <div class="row">
        <ul class="nav nav-pills nav-stacked">
            <li><a class="row-md-12" href="#">Plaats veiling</a></li>
            <li><a class="row-md-12" href="#">Login</a></li>
        </ul>
    </div>
</div>

<!-- Filter bar -->

<div class="container-fluid">
    <div class="col-md-3">
        <div class="visible-lg visible-md visible-sm visible-xs">
            <div class="list-group">
                <a href="#" class="list-group-item active">Opties</a>

                <form method="get" action="resultaten.php">

                    <input type="hidden" name="zoekterm" value="<?php global $zoekterm;
                    echo($zoekterm); ?>">

                    <a href="#" class="list-group-item"> Filter:
                        <select class="form-control" name="sorteerfilter">
                            <?php
                            if (isset($sorteerfilter)) {
                                global $sorteerfilter;
                                echo('<option value="' . $sorteerfilter . '" selected> ' . $sorteerfilter . '</option>');
                            }
                            ?>
                            <option value="Tijd: nieuw aangeboden">Tijd: nieuw aangeboden</option>
                            <option value="Tijd: eerst afgelopen">Tijd: eerst afgelopen</option>
                            <option value="Prijs: laagste bovenaan">Prijs: laagste bovenaan</option>
                            <option value="Prijs: hoogste bovenaan">Prijs: hoogste bovenaan</option>
                            <option value="Afstand: dichtstbijzijnde eerst">Afstand: dichtstbijzijnde eerst</option>
                        </select>
                    </a>

                    <a href="#" class="list-group-item">Prijs: <b>€ 10 - € 1000</b>
                        <input id="pslider" type="text" name="prijs"
                               class="span2" value=""
                               data-slider-min="10"
                               data-slider-max="1000"
                               data-slider-step="5"
                               <?php
                               data-slider-value="[150,450]"/>
                               ?>
                    </a>


                    <a href="#" class="list-group-item">Betalingsmethode:
                        <select class="form-control" id="betalingsmethode" name="betalingsmethode">
                            <?php
                            if (isset($betalingsmethode)) {
                                global $betalingsmethode;
                                echo('<option value="' . urldecode($betalingsmethode) . '" selected>' . urldecode($betalingsmethode) . '</option>');
                            }
                            global $betalingswijzenresult;
                            foreach ($betalingswijzenresult as $betalingswijze) {
                                echo('<option> ' . $betalingswijze[Betalingswijze] . '</option>');
                            }
                            ?>
                        </select>
                    </a>

                    <a href="#" class="list-group-item">
                        <input class="btn btn-primary" type="submit" data-inline="true" value="Aanpassen">
                    </a>

                    <script>
                        var slider = new Slider('#pslider', {});
                    </script>

                </form>
            </div>


            <a href="#" class="list-group-item active" id="Header-Categories">
                Categorieën
            </a>
            <a href="#" class="list-group-item">Auto's</a>
            <a href="#" class="list-group-item">Electronica</a>
            <a href="#" class="list-group-item">Boeken</a>
            <a href="#" class="list-group-item">Vestibulum at eros</a>
            <a href="#" class="list-group-item">Electronica</a>
            <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>
        </div>
    </div>

    <!-- Trending items -->

    <div class="well well-sm col-md-9 pull-left">
        <h2>Resultaten</h2>

        <!-- test -->

        <div class="well well-sm">
            <strong>Display</strong>
            <div class="btn-group">
                <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
            </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-th"></span>Grid</a>
            </div>
        </div>
        <?php
        global $result;
        outputRows($result, $zoekterm);
        ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#list').click(function (event) {
            event.preventDefault();
            $('#products .item').addClass('list-group-item');
        });
        $('#grid').click(function (event) {
            event.preventDefault();
            $('#products .item').removeClass('list-group-item');
            $('#products .item').addClass('grid-group-item');
        });
    });
</script>
</body>
</html>