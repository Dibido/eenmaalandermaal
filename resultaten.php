<?php
require 'PHP/Connection.php';
require 'PHP/Functions.php';
require 'PHP/SQL-Queries.php';
$waardes = array("0" => "VW_looptijdStart DESC", "1" => "VW_looptijdEinde ASC", "2" => "prijs ASC", "3" => "prijs DESC");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['zoekterm'])) {
        $zoekterm = ($_GET['zoekterm']);
    }
    if (isset($_GET['sorteerfilter'])) {
        $sorteerfilter = ($_GET['sorteerfilter']);
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
    if (!isset($_GET['zoekterm'])) {
        $zoekterm = $_GET['zoekterm'] = "";
    }
    if (!isset($_GET['sorteerfilter'])) {
        $_GET['sorteerfilter'] = 0;
        $sorteerfilter = $_GET['sorteerfilter'];
    }
    if (!isset($_GET['betalingsmethode'])) {
        $_GET['betalingsmethode'] = 'NULL';
        $betalingsmethode = 0;
    }
    if (!isset($_GET['categorie'])) {
        $_GET['categorie'] = "NULL";
        $categorie = "NULL";
    }
    if (!isset($_GET['min'])) {
        $_GET['min'] = "NULL";
    }
    if (!isset($prijs['min'])) {
        $prijs['min'] = 0;
    }
    if (!isset($prijs['max'])) {
        $prijs['max'] = 50000;
    }


    //This checks to see if there is a page number, that the number is not 0, and that the number is actually a number. If not, it will set it to page number to 1.
    if ((!isset($_GET['pagenum'])) || (!is_numeric($_GET['pagenum'])) || ($_GET['pagenum'] < 1)) {
        $pagenum = 1;
    } else {
        $pagenum = $_GET['pagenum'];
    }
    //results per page
    $ResultsPerPage = 12;
    $Offset = $ResultsPerPage * ($pagenum - 1);
    echo $pagenum;
    $_GET['maxremainingtime'] = "NULL";
    $_GET['minremainingtime'] = "NULL";
    $Dictionary = array(
        'SearchKeyword' => $_GET['zoekterm'],
        'SearchFilter' => $waardes[($_GET['sorteerfilter'])],
        'SearchPaymentMethod' => $_GET['betalingsmethode'],
        'SearchCategory' => $_GET['categorie'],
        'SearchMinRemainingTime' => $_GET['minremainingtime'],
        'SearchMaxRemainingTime' => $_GET['maxremainingtime'],
        'SearchMinPrice' => $prijs['min'],
        'SearchMaxPrice' => $prijs['max'],
        'ResultsPerPage' => $ResultsPerPage,
        'Offset' => $Offset
    );
}
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
                    <button class="btn btn-default navbar-btn hidden-sm hidden-xsv NavRightButton">
                        <i class="glyphicon glyphicon-user"></i>
                    </button>
                </li>

            </ul>
        </div>

        <form class="navbar-form" action="resultaten.php" method="GET">
            <div class="form-group" style="display:inline;">
                <div class="input-group" style="display:table;">
                    <input class="form-control" name="zoekterm" placeholder="Search Here" autocomplete="off"
                           autofocus="autofocus" type="text"">
                    <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button class="btn btn-secondary"
                                                                                               type="submit"
                                                                                               style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                    class="glyphicon glyphicon-search"></span></button></span>
                </div>
            </div>
        </form>
    </div>
</nav>


<!-- Filter bar -->

<div class="container-fluid">
    <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12">
        <div class="visible-lg visible-md visible-sm visible-xs">
            <div class="list-group">
                <a href="#" class="list-group-item active">Opties</a>

                <form method="get" action="resultaten.php" id="sorteerForm">
                    <a href="#" class="list-group-item">
                        <div class="input-group" style="display:table;">
                            <input class="form-control" name="zoekterm" id="zoekterm1" placeholder="Search Here" autocomplete="off"
                                   autofocus="autofocus" type="text" value='<?php $zoekterm ?>'>
                            <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button
                                        class="btn btn-secondary" type="submit"
                                        style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                            class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    </a>

                    <a href="#" class="list-group-item"> Sorteer op:
                        <select class="form-control" name="sorteerfilter">
                            <?php
                            $filterNamen = array("Tijd: nieuw aangeboden", "Tijd: eerst afgelopen", "Prijs: laagste bovenaan", "Prijs: hoogste bovenaan");
                            if (isset($sorteerfilter)) {
                                global $sorteerfilter;
                                //echo "<option value=\"" . ($_GET['sorteerfilter']) . "\" selected>" . $filterNamen[($_GET['$sorteerfilter'])] . "</option>"; */

                                $query_age = (isset($_GET['query_age']) ? $_GET['query_age'] : null);
                            }
                            ?>
                            <option value="0">Tijd: nieuw aangeboden</option>
                            <option value="1">Tijd: eerst afgelopen</option>
                            <option value="2">Prijs: laagste bovenaan</option>
                            <option value="3">Prijs: hoogste bovenaan</option>
                        </select>
                    </a>

                    <a href="#" class="list-group-item">Prijs:
                        <b><?php echo('€' . $prijs['min'] . '- €' . $prijs['max']); ?></b>

                        <div list-group-item>
                            <input id="pslider" type="text" name="prijs"
                                   class="span2" value=""
                                   data-slider-min="0"
                                   data-slider-max="5000"
                                   data-slider-step="5"
                            <?php
                            if (isset($prijs)) {
                                echo('data-slider-value="[' . $prijs['min'] . "," . $prijs['max'] . ']"/>');
                            } else {
                                echo('data-slider-value="[150,450]"/>');
                            }
                            ?>
                        </div>
                    </a>

                    <a href="#" class="list-group-item">Betalingsmethode:
                        <select class="form-control" name="betalingsmethode">
                            <?php
                            if (isset($betalingsmethode)) {
                                global $betalingsmethode;
                                echo('<option value="' . $_GET['betalingsmethode'] . '" selected> ' . $_GET['betalingsmethode'] . '</option>');
                            }
                            ?>
                            <option value="Bank / Giro">Bank / Giro</option>
                            <option value="Contant">Contant</option>
                            <option value="Anders">Anders</option>
                            <option value="Prijs: hoogste bovenaan">Prijs: hoogste bovenaan</option>
                        </select>
                        <!--<select class="form-control" id="betalingsmethode" name="betalingsmethode">
                            <? /*php
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
                    <ul class="list-group-item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-5 col-lg-6">
                                <a href="resultaten.php?zoekterm=<?php echo "<a href=" . "

                                    ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urldecode($sorteerfilter) . "&prijs=" . urldecode($prijs) . "&pagenum=" . $pagenum . ">Volgende ></a> ";
                                ?>">
                                    <button class="btn btn-warning"
                                            type="button">
                                            <span
                                                    class="glyphicon glyphicon-repeat"></span> Reset
                                    </button>
                                </a>

                            </div>
                            <div class="col-xs-6 col-sm-6s col-md-5 col-lg-6">

                                <a href="#">
                                    <button class="btn btn-primary"
                                            type="submit"><span
                                                class="glyphicon glyphicon-wrench"></span>Aanpassen
                                    </button>
                                </a>
                            </div>


                        </div>
                    </ul>
                    <script>
                        var slider = new Slider('#pslider', {});
                        var slider = new Slider('#rslider', {});
                    </script>
                    <input type="hidden" name="categorie" value="<?php global $categorie;
                    echo($categorie); ?>">
                    <input type="hidden" name="pagenum" value="<?php global $pagenum;
                    echo($pagenum); ?>">

            </div>
            <a href="#" class="list-group-item active" id="Header-Categories">
                <i class="text-right glyphicon glyphicon-th-list"></i>
                Categorieën
            </a>
            <div class="list-group-item">
                <ul class="nav nav-list">
                    <?php printCategoriën($zoekterm, $categorie,$sorteerfilter,$prijs,$betalingsmethode);
                    ?>
                </ul>
            </div>


            <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>


        </div>
    </div>
    </form>

    <!-- Trending items -->

    <div class="col-md-9 pull-left">
        <h2>Resultaten</h2>
        <?php
        global $Dictionary;
        $result = SearchFunction($Dictionary);
        outputRows($result, $Dictionary["SearchKeyword"]);
        ?>

        <!-- pagina nummering -->
        <?php

        // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
        if ($pagenum == 1) {
        } else {
            //eerste pagina
            echo " <a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . '1' . "> <<-Eerste pagina</a>";


            echo " ";
            $previous = $pagenum - 1;
            //vorige pagina
            echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $previous . "> <-Vorige</a>";
        }
        //just a spacer
        echo " ---- ";
        //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
        if ($pagenum == $last) {
        } else {
            $next = $pagenum + 1;
            echo " <a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $next . ">Volgende ></a> ";
            echo " ";
            echo " <a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $last . ">Laatste pagina ->></a> ";
            //"<a href='?pagenum=$last'>Laatste pagina ->></a> ";
            print_r($prijs);
        }
        ?>

        <!-- HTML -->
        <html>
        <nav aria-label="...">
            <ul class="pagination">
                <?php if($pagenum != 1){
                echo '<li class="page-item">';
                echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=".'1'."><< Eerste</a> ";
                echo '</li><li class="page-item">';
                echo  "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $previous . "> <- Vorige</a> ";
                echo '</li>';
                }
                $lastPageNum = $pagenum + 5;
                $startPage = $pagenum;
                if($pagenum != 1) {
                    $startPage--;
                    $lastPageNum--;
                }

                for($i = $startPage; $i<$lastPageNum; $i++){
                    if($i == $pagenum){
                        echo'<li class="page-item active"><span class="page-link">';
                        echo $i;
                        echo'<span class="sr-only">(current)</span></span></li>';
                    }else{
                        echo '<li class="page-item"><a class="page-link" href="#">';
                        echo $i;
                        echo '</a></li>';
                    }
                }
                ?>

                <li class="page-item">
                   <?php echo  "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($categorie) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $next . ">Volgende -></a> ";?>
                </li>
            </ul>
        </nav>

        </html>

        <!-- Einde Paginanummering-->

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
<script type="text/javascript">
    $(document).ready(function () {
        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle(200);
        });
    });
</script>

</body>
</html>