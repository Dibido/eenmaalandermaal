<?php
require 'PHP/Connection.php';
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

global $prijs;
if (!isset($_GET['zoekterm'])) {
    $_GET['zoekterm'] = "NULL";
}
if (!isset($_GET['sorteerfilter'])) {
    $_GET['sorteerfilter'] = 'Tijd: nieuw aangeboden';
}
if (!isset($_GET['betalingsmethode'])) {
    $_GET['betalingsmethode'] = "NULL";
}
if (!isset($_GET['categorie'])) {
    $_GET['categorie'] = "NULL";
}
if (!isset($_GET['subcategorie'])) {
    $_GET['subcategorie'] = "NULL";
}
if (isset($_GET['subsubcategorie'])) {
    $_GET['subsubcategorie'] = "NULL";
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


$_GET['subsubcategory'] = "NULL";
$_GET['maxremainingtime'] = "NULL";
$_GET['minremainingtime'] = "NULL";

$Dictionary = array(
    'SearchKeyword' => $_GET['zoekterm'],
    'SearchFilter' => $_GET['sorteerfilter'],
    'SearchPaymentMethod' => $_GET['betalingsmethode'],
    'SearchCategory' => $_GET['categorie'],
    'SearchSubCategory' => $_GET['subcategorie'],
    'SearchSubSubCategory' => $_GET['subsubcategory'],
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
    <!--<link rel="stylesheet" href="CSS/resultaten.css">

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

            <?php
            if (isset($subcategorie)) {
                $categorieQuery = "select
                distinct Rubriek.RB_Naam as Subsubcategorie,
                count(Rubriek.RB_Naam) as aantal,
                Rubriek.RB_Nummer as CategorieNummer
                from Voorwerp
                Inner join Voorwerp_Rubriek
                on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                Inner join Rubriek
                on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                Inner join Rubriek r1
                on r1.RB_Nummer = Rubriek.RB_Parent
                Inner join Rubriek r2
                on r2.RB_Nummer = r1.RB_Parent
                Where r2.RB_Naam != 'root'and Voorwerp.VW_titel like '%$zoekterm%' and Rubriek.RB_Parent = $subcategorie
                GROUP BY Rubriek.RB_Naam, Rubriek.RB_Nummer
                ORDER BY COUNT(Rubriek.RB_Naam) desc";
                $categorieResult = $connection->query($categorieQuery)->fetchAll(PDO::FETCH_ASSOC);
                echo '
            <a href="#" class="list-group-item active" id="Header-Categories">
                Categorieën
            </a>
            ';
                foreach ($categorieResult as $categorie) {
                    $url = urlencode($categorie['CategorieNummer']);
                    echo('<a href= " ' . $_SERVER['REQUEST_URI'] . '&subsubcategorie=' . $url . '" class = \'list-group-item\'><h4>' . $categorie['Subsubcategorie'] . ' (' . $categorie['aantal'] . ')' . '</h4></a>');

                }
            } elseif (isset($categorie)) {
                $categorieQuery = "select
                                        distinct r1.RB_Naam as Subcategorie,
                                        r2.RB_Nummer as Hoofdcategorie,
                                        count(r1.RB_Naam) as aantal,
                                        r1.RB_Nummer as CategorieNummer
                                        from Voorwerp
                                        Inner join Voorwerp_Rubriek
                                        on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                                        Inner join Rubriek
                                        on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                                        Inner join Rubriek r1
                                        on r1.RB_Nummer = Rubriek.RB_Parent
                                        Inner join Rubriek r2
                                        on r2.RB_Nummer = r1.RB_Parent
                                        Where r2.RB_Naam != 'root'and Voorwerp.VW_titel like '%$zoekterm%' and r1.RB_Parent = $categorie
                                        GROUP BY r1.RB_Naam,r1.RB_Nummer, r2.RB_Naam, r2.RB_Nummer
                                        ORDER BY COUNT(r1.RB_Naam) desc";
                $categorieResult = $connection->query($categorieQuery)->fetchAll(PDO::FETCH_ASSOC);
                echo '
            <a href="#" class="list-group-item active" id="Header-Categories">
                Categorieën
            </a>';
                foreach ($categorieResult as $categorie) {
                    $url = urlencode($categorie['CategorieNummer']);
                    echo('<a href= " ' . $_SERVER['REQUEST_URI'] . '&subcategorie=' . $url . '" class = \'list-group-item\'><h4>' . $categorie['Subcategorie'] . ' (' . $categorie['aantal'] . ')' . '</h4></a>');

                }
            } else {
                $categorieQuery = "select
                            distinct r2.RB_Naam as Hoofdcategorie,
                            count(r2.RB_Naam) as aantal,
                            r2.RB_Nummer as CategorieNummer
                            from Voorwerp
                            Inner join Voorwerp_Rubriek
                            on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                            Inner join Rubriek
                            on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                            Inner join Rubriek r1
                            on r1.RB_Nummer = Rubriek.RB_Parent
                            Inner join Rubriek r2
                            on r2.RB_Nummer = r1.RB_Parent
                            Where r2.RB_Naam != 'root'and Voorwerp.VW_titel like '%$zoekterm%'
                            GROUP BY r2.RB_Naam,r2.RB_Nummer
                            ORDER BY COUNT(r2.RB_Naam) desc";
                $categorieResult = $connection->query($categorieQuery)->fetchAll(PDO::FETCH_ASSOC);
                echo '
            <a href="#" class="list-group-item active" id="Header-Categories">
                Categorieën
            </a>';
                foreach ($categorieResult as $categorie) {
                    $url = urlencode($categorie['CategorieNummer']);
                    echo('<a href= " ' . $_SERVER['REQUEST_URI'] . '&categorie=' . $url . '" class = \'list-group-item\'><h4>' . $categorie['Hoofdcategorie'] . ' (' . $categorie['aantal'] . ')' . '</h4></a>');
                }
            }


            /*<a href="#" class="list-group-item"></a>

            <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>
                        */ ?>
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