<?php
require 'PHP/Connection.php';
require 'PHP/Functions.php';
require 'PHP/SQL-Queries.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['zoekterm'])) {
        $zoekterm = ($_GET['zoekterm']);
    } else {
        $zoekterm = $_GET['zoekterm'] = "";
    }
    if (isset($_GET['sorteerfilter'])) {
        $sorteerfilter = ($_GET['sorteerfilter']);
    } else {
        $_GET['sorteerfilter'] = 0;
        $sorteerfilter = $_GET['sorteerfilter'];
    }
    if (isset($_GET['betalingsmethode'])) {
        $betalingsmethode = $_GET['betalingsmethode'];
    } else {
        $_GET['betalingsmethode'] = 'NULL';
        $betalingsmethode = 0;
    }
    if (isset($_GET['prijs'])) {
        $tmp = explode(',', $_GET['prijs']);
        $prijs = array('min' => round($tmp[0]), 'max' => round($tmp[1]));
        unset($tmp);
    }
    if (isset($_GET['rubriek'])) {
        $rubriek = ($_GET['rubriek']);
    } else {
        $_GET['rubriek'] = "NULL";
        $rubriek = "NULL";
    }
    if (isset($_GET['user'])) {
        $user = ($_GET['user']);
    } else {
        $user = "NULL";
    }

    if (!isset($prijs['min'])) {
        $prijs['min'] = 0;
    }
    if (!isset($prijs['max'])) {
        $prijs['max'] = 1000;
    }
    //This checks to see if there is a page number, that the number is not 0, and that the number is actually a number. If not, it will set it to page number to 1.
    if ((!isset($_GET['pagenum'])) || (!is_numeric($_GET['pagenum'])) || ($_GET['pagenum'] < 1)) {
        $pagenum = 1;
    } else {
        $pagenum = round($_GET['pagenum']);
    }
    //results per page
    $ResultsPerPage = 12;
    $Offset = $ResultsPerPage * ($pagenum - 1);
    $_GET['maxremainingtime'] = "NULL";
    $_GET['minremainingtime'] = "NULL";
    //Waardes is an array that contains the right term to for the query. the form outputs 0-3 each number has their own value in the array
    $waardes = array("VW_looptijdStart DESC", "VW_looptijdEinde ASC", "prijs ASC", "prijs DESC");
    //Create dictionary with all variables from the GET request. Dictionary is used to give all values to the query
    $Dictionary = array(
        'SearchKeyword' => $_GET['zoekterm'],
        'SearchFilter' => $waardes[($_GET['sorteerfilter'])],
        'SearchPaymentMethod' => $_GET['betalingsmethode'],
        'SearchCategory' => $_GET['rubriek'],
        'SearchMinRemainingTime' => $_GET['minremainingtime'],
        'SearchMaxRemainingTime' => $_GET['maxremainingtime'],
        'SearchMinPrice' => $prijs['min'],
        'SearchMaxPrice' => $prijs['max'],
        'ResultsPerPage' => $ResultsPerPage,
        'Offset' => $Offset,
        'SearchUser' => $user
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
    <meta name="viewport" content="width=device-width, initial-scale=1">


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
<?php
require('navbar.html');
?>

<!-- Filter bar -->
<div class="container-fluid">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="list-group">
            <div class="list-group-item active">Sorteer Opties</div>
            <form method="get" action="resultaten.php" id="sorteerForm">
                <!-- Search on keyword -->
                <div class="list-group-item">
                    <div class="input-group" style="display:table;">
                        <input class="form-control" name="zoekterm" placeholder="Search Here"
                               type="text" value='<?php echo $zoekterm; ?>'>
                        <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button
                                    class="btn btn-secondary" type="submit"
                                    style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                        class="glyphicon glyphicon-search"></span></button></span>
                    </div>
                </div>
                <!-- Sort by select form -->
                <div class="list-group-item"> Sorteer op:
                    <select class="form-control" name="sorteerfilter">
                        <?php
                        //Array to be able to create a for loop. When adding a new one nothing has to be changed this way.
                        $filterNamen = array("Tijd: nieuw aangeboden", "Tijd: eerst afgelopen", "Prijs: laagste bovenaan", "Prijs: hoogste bovenaan");
                        if (isset($sorteerfilter)) {
                            echo "<option value=" . ($_GET['sorteerfilter']) . " selected>" . $filterNamen[$sorteerfilter] . "</option>";
                            echo $filterNamen[$sorteerfilter];
                        }
                        //Creates all options in the array $filterNamen
                        for ($i = 0; $i < sizeof($filterNamen); $i++) {
                            if ($_GET['sorteerfilter'] != $i) {
                                echo "<option value=" . $i . ">" . $filterNamen[$i] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Price slider -->
                <div class="list-group-item">Prijs:
                    <b><?php echo('€' . $prijs['min'] . '- €' . $prijs['max']); ?></b>
                    <div list-group-item>
                        <input id="pslider" type="text" name="prijs"
                               class="span2" value=""
                               data-slider-min="0"
                               data-slider-max="1000"
                               data-slider-step="1"
                        <?php
                        if (isset($prijs)) {
                            echo('data-slider-value="[' . $prijs['min'] . "," . $prijs['max'] . ']"/>');
                        } else {
                            echo('data-slider-value="[150,450]"/>');
                        }
                        ?>
                    </div>
                </div>

                <!-- Payment method select form -->

                <div class="list-group-item">Betalingsmethode:
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
                </div>

                <!-- Search ads by certain user -->

                <div class="list-group-item">
                    <div class="input-group">
                        <input class="form-control" name="user" placeholder="Search Here" value="<?php echo $user; ?> "autocomplete="off"
                               type="text">
                        <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button
                                    class="btn btn-secondary" type="submit"
                                    style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                        class="glyphicon glyphicon-user"></span></button></span>
                    </div>
                </div>

                <!-- Reset and Adjust buttons -->

                <ul class="list-group-item">
                    <div class="row">

                        <!-- Reset all searchterms only thing kept is the seachkeyword-->

                        <div class="col-xs-6 col-sm-6 col-md-5 col-lg-6">
                            <button class="btn btn-warning center-block btn-lg " type="reset">
                                <a style="color: #ffffff"
                                   href="resultaten.php?zoekterm=<?php echo urldecode($zoekterm) ?> ">
                                    <span class="glyphicon glyphicon-repeat"></span> Reset
                                </a>
                            </button>
                        </div>

                        <!-- Adjust button -->

                        <div class="col-xs-6 col-sm-6 col-md-5 col-lg-6">
                            <button class="btn btn-primary center-block btn-lg" type="submit">
                                <span class="glyphicon glyphicon-wrench"></span>Aanpassen
                            </button>
                        </div>


                    </div>
                </ul>

                <!-- Invisible input fields to submit values not set in the form -->

                <input type="hidden" name="rubriek" value="<?php echo($rubriek); ?>">
                <input type="hidden" name="pagenum" value="<?php echo($pagenum); ?>">

        </div>


        <!-- Categories -->

        <li class="list-group-item active" id="Header-Categories">
            <i class="text-right glyphicon glyphicon-th-list"></i>
            Rubrieken
        </li>
        <div class="list-group-item panel-collapse collapse in">
            <?php
            printCategoriën($zoekterm, $rubriek, $sorteerfilter, $prijs, $betalingsmethode);
            ?>
        </div>

        <!-- Open and close alle Categories -->
        <!-- Opened on entry on Desktop and Closed at entry on mobile-->

        <a href="#" class="seeMore list-group-item active" data-toggle="collapse" data-target="#Rubrieken"
           data-parent="#Rubrieken" id="Header-Categories">
            <i class="text-right glyphicon glyphicon-th-list"></i>
            Sluit rubrieken
        </a>

    </div>
    </form>

    <!-- Results -->

    <div class="col-md-9 col-sm-12 col-xs-12 pull-left">
        <?php
        global $Dictionary;
        $result = SearchFunction($Dictionary);
        outputRows($result, $Dictionary["SearchKeyword"]);
        ?>

        <div class="col-md-9 col-sm-12 col-xs-12 col-md-push-3 col-sm-push-4 col-xs-push-4">
            <ul class="pagination">

                <?php
                if (!empty($result)) {
                    //Returns the amount of results on the next 4 pages.
                    $amountOfResults = amountOfResultsLeft($Dictionary);
                    //Calculate the amount of pages by deviding the count with the amount of results per page.
                    $amountOfFuturePages = ceil($amountOfResults[0]['totaal'] / $ResultsPerPage);
                    $previousPage = $pagenum - 1;
                    $lastPageNum = $pagenum + $amountOfFuturePages + 2;
                    $startPage = $pagenum - 4 + $amountOfFuturePages;
                    $nextPage = $pagenum + 1;

                    // If the current page is not the first one. The first pagenumber created has to be the one before the current page.
                    if ($pagenum != 1) {
                        $startPage--;
                        $lastPageNum--;
                        echo '<li class="page-item">';
                        echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $previousPage . "> <- Vorige</a> ";
                        echo '</li>';
                    }
                    //Loop creates all buttons to the next or pages before the current one.
                    for ($i = $startPage; $i < $lastPageNum; $i++) {
                        if ($i == $pagenum) {
                            echo '<li class="page-item active text-center">';
                            echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $i . ">" . $i . "</a> ";
                            echo '</li>';
                        } else {
                            echo '<li class="page-item">';
                            echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $i . ">" . $i . "</a> ";
                            echo '</li>';
                        }
                    }
                    //Only when the amount of future pages is 1 or higher the next button will be created. This since there is no next page when there are no future pages.
                    if ($amountOfFuturePages > 0) {
                        echo '<li class="page-item">';
                        echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . $nextPage . ">Volgende -></a> ";
                        echo '</li></ul>';
                    }
                }
                //If the page does not exist since there aren't enough results an error message will be shown. If the current page is one there won't be shown an error message
                //this since there are no results at all and not that there aren't enough results.
                elseif ($pagenum != 1) {
                    echo '<h1> Page ' . $pagenum . ' does not exist</h1>';
                }
                echo '</div>' ?>


                <!-- Einde Paginanummering-->

        </div>
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
        $(document).ready(function () {
            $('.tree-toggle').click(function () {
                $(this).parent().children('ul.tree').toggle(200);
            });
        });

        //If the screen width < 1200 the Categories will be closed on entry by removing the class in. This means that close categories also has to be changed to Open Categories.
        $(document).ready(function () {
            if ($(window).width() <= 1200) {
                $(".seeMore").text('Open Rubrieken');
                $("#Rubrieken").removeClass("in");
            }
        });
        //Changes the open/closed categories when opened or closed.
        $('.seeMore').click(function () {
            var $this = $(this);
            $this.toggleClass('seeMore');
            if ($(window).width() <= 1200) {
                if ($this.hasClass('seeMore')) {
                    $this.text('Open Rubrieken');
                } else {
                    $this.text('Sluit Rubrieken');
                }
            } else {
                if ($this.hasClass('seeMore')) {
                    $this.text('Sluit Rubrieken');
                } else {
                    $this.text('Open Rubrieken');
                }
            }
        });
        var slider = new Slider('#pslider', {});
    </script>
    </body >
    </html >