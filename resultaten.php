<?php
require 'PHP/Connection.php';
require 'PHP/Functions.php';

$waardes = array("Tijd: nieuw aangeboden" => "VW_looptijdStart DESC", "Tijd: eerst afgelopen" => "VW_looptijdEinde ASC", "Prijs: laagste bovenaan" => "prijs ASC", "Prijs: hoogste bovenaan" => "prijs DESC");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
if (isset($_GET['zoekterm'])) {
    $zoekterm = ($_GET['zoekterm']);
}

if (isset($_GET['sorteerfilter'])) {
    $sorteerfilter = $waardes[($_GET['sorteerfilter'])];
}
if (isset($_GET['betalingsmethode'])) {
    $betalingsmethode = $_GET['betalingsmethode'];
}
if (isset($_GET['prijs'])) {
    $tmp = explode(',', $_GET['prijs']);
    $prijs = array('min' => $tmp[0], 'max' => $tmp[1]);
    unset($tmp);
}
if (isset($_GET['categorie'])) {
    $categorie = ($_GET['categorie']);
}
if (isset($_GET['subcategorie'])) {
    $subcategorie = ($_GET['subcategorie']);
}
if (isset($_GET['subsubcategorie'])) {
    $subsubcategorie = ($_GET['subsubcategorie']);
}
if (!isset($_GET['zoekterm'])) {
    $_GET['zoekterm'] = "NULL";
}
if (!isset($_GET['sorteerfilter'])) {
    $_GET['sorteerfilter'] = "Tijd: nieuw aangeboden";
}
if (!isset($_GET['betalingsmethode'])) {
    $_GET['betalingsmethode'] = "NULL";
}
if (!isset($_GET['categorie'])) {
    $_GET['categorie'] = "NULL";
    $categorie = "NULL";
}
if (!isset($_GET['subcategorie'])) {
    $_GET['subcategorie'] = "NULL";
    $subcategorie = "NULL";
}
if (!isset($_GET['subsubcategorie'])) {
    $_GET['subsubcategorie'] = "NULL";
    $subsubcategorie = "NULL";
}
if (!isset($_GET['min'])) {
    $_GET['min'] = "NULL";
}
if (!isset($prijs['min'])) {
    $prijs['min'] = 0;
}
if (!isset($prijs['max'])) {
    $prijs['max'] = 5000;
}

$_GET['maxremainingtime'] = "NULL";
$_GET['minremainingtime'] = "NULL";

$Dictionary = array(
    'SearchKeyword' => $_GET['zoekterm'],
    'SearchFilter' => $waardes[($_GET['sorteerfilter'])],
    'SearchPaymentMethod' => $_GET['betalingsmethode'],
    'SearchCategory' => $_GET['categorie'],
    'SearchSubCategory' => $_GET['subcategorie'],
    'SearchSubSubCategory' => $_GET['subsubcategorie'],
    'SearchMinRemainingTime' => $_GET['minremainingtime'],
    'SearchMaxRemainingTime' => $_GET['maxremainingtime'],
    'SearchMinPrice' => $prijs['min'],
    'SearchMaxPrice' => $prijs['max']
);

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

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Bootply snippet - Bootstrap Bootstrap Tree Menu</title>
    <meta name="generator" content="Bootply">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description"
          content="Bootstrap Multi-level tree view menu with Bootstrap. Expand and collapse sub sections. example.">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">

    <!-- bootstrap !-->
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/HomePage.css">
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">

    <!-- CSS voor price slider -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/css/bootstrap-slider.css">
    <link rel="stylesheet" href="CSS/resultaten.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/bootstrap-slider.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
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
                    <input class="form-control" id="searchbar" name="zoekterm" placeholder="Search Here"
                           autocomplete="off"
                           autofocus="autofocus" type="text">
                    <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button class="btn btn-secondary"
                                                                                               type="submit"
                                                                                               style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                    class="glyphicon glyphicon-search"></span></button></span>
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
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="visible-lg visible-md visible-sm visible-xs">
            <div class="list-group">
                <a href="#" class="list-group-item active">Opties</a>

                <form method="get" action="resultaten.php">

                    <input type="hidden" name="zoekterm" value="<?php global $zoekterm;
                    echo($zoekterm); ?>">
                    <input type="hidden" name="categorie" value="<?php global $categorie;
                    echo($categorie); ?>">
                    <input type="hidden" name="subcategorie" value="<?php global $subcategorie;
                    echo($subcategorie); ?>">
                    <input type="hidden" name="subsubcategorie" value="<?php global $subsubcategorie;
                    echo($subsubcategorie); ?>">

                    <a href="#" class="list-group-item"> Filter:
                        <select class="form-control" name="sorteerfilter">
                            <?php
                            if (isset($sorteerfilter)) {
                                global $sorteerfilter;
                                echo('<option value="' . ($_GET['sorteerfilter']) . '" selected> ' . ($_GET['sorteerfilter']) . '</option>');
                            }
                            ?>
                            <option value="Tijd: nieuw aangeboden">Tijd: nieuw aangeboden</option>
                            <option value="Tijd: eerst afgelopen">Tijd: eerst afgelopen</option>
                            <option value="Prijs: laagste bovenaan">Prijs: laagste bovenaan</option>
                            <option value="Prijs: hoogste bovenaan">Prijs: hoogste bovenaan</option>
                        </select>
                    </a>

                    <a href="#" class="list-group-item">Prijs:
                        <b><?php echo('€' . $prijs['min'] . '- €' . $prijs['max']); ?></b>
                        <input id="pslider" type="text" name="prijs"
                               class="span2" value=""
                               data-slider-min="10"
                               data-slider-max="5000"
                               data-slider-step="5"
                        <?php
                        if (isset($prijs)) {
                            echo('data-slider-value="[' . $prijs['min'] . "," . $prijs['max'] . ']"/>');
                        } else {
                            echo('data-slider-value="[150,450]"/>');
                        }
                        }
                        ?>
                    </a>


                    <a href="#" class="list-group-item">Betalingsmethode:
                        <!--<select class="form-control" id="betalingsmethode" name="betalingsmethode">
                            <?/*php
                            if (!isset($betalingsmethode)) {
                                global $betalingsmethode;
                                echo('<option value="' . urldecode($betalingsmethode) . '" selected>' . urldecode($betalingsmethode) . '</option>');
                            }
                            global $betalingswijzenresult;
                            foreach ($betalingswijzenresult as $betalingswijze) {
                                echo('<option> ' . $betalingswijze[Betalingswijze] . '</option>');
                            }*/
                            ?>
                        </select>-->
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
            <div class="list-group-item">
                <ul class="nav nav-list">
                    <?php printCategoriën($zoekterm);
                    ?>
                </ul>
            </div>


            <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>


        </div>
    </div>

    <!-- Trending items -->

    <div class="col-md-9 pull-left">
        <h2>Resultaten</h2>
        <?php
        global $Dictionary;
        $test = SearchFunction($Dictionary);
        if (!empty($test)) {
            if ($test[0]) {
                foreach ($test as $advert) {
                    DrawSearchResults($advert);
                }
            } else {
                echo "<b>Error on loading auctions: </b>" . "<br><br>" . $test[1];
            }
        }
        ?>
        <nav aria-label="pagination">
            <ul class="pagination pull-right">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Vorige</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Volgende</a></li>
          </ul>
        </nav>
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
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle(200);
        });

    });
</script>

</body>
</html>