<?php
session_start();
require 'PHP/Connection.php';
require 'PHP/Functions.php';
require 'PHP/SQL-Queries.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['zoekterm'])) {
        $zoekterm = ($_GET['zoekterm']);
    } else{
        $zoekterm = '';
    }
    if (isset($_GET['sorteerfilter'])) {
        $sorteerfilter = ($_GET['sorteerfilter']);
    } else {
        $sorteerfilter = 0;
    }
    if (isset($_GET['betalingsmethode'])) {
        $betalingsmethode = $_GET['betalingsmethode'];
    }else{
        $betalingsmethode = $_GET['betalingsmethode'];
    }
    if (isset($_GET['prijs'])) {
        $tmp = explode(',', $_GET['prijs']);
        $prijs = array('min' => round($tmp[0]), 'max' => round($tmp[1]));
        unset($tmp);
    }
    if (isset($_GET['rubriek']) && !empty($_GET['rubriek'])) {
        $rubriek = ($_GET['rubriek']);
    } else {
        $rubriek = 'NULL';
    }
    if (isset($_GET['user'])) {
        $user = ($_GET['user']);
    } else {
        $user = "";
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
    $pagenum = cleanInput(urldecode($pagenum));
    $ResultsPerPage = 12;
    $zoekterm = cleanInput(urldecode($zoekterm));
    $rubriek = cleanInput(urldecode($rubriek));
    $sorteerfilter = cleanInput(urldecode($sorteerfilter));
    $betalingsmethode = cleanInput(urldecode($betalingsmethode));
    $user = cleanInput(urldecode($user));
    $ResultsPerPage = 12;
    $Offset = $ResultsPerPage * ($pagenum - 1);
    $_GET['maxremainingtime'] = "NULL";
    $_GET['minremainingtime'] = "NULL";
    //Waardes is an array that contains the right term to for the query. the form outputs 0-3 each number has their own value in the array
    $waardes = array("VW_looptijdStart DESC", "VW_looptijdEinde ASC", "prijs ASC", "prijs DESC", "GEB_rating DESC", "GEB_rating ASC", "VW_bodcount DESC", "VW_bodcount ASC", "VW_titel ASC", "VW_titel DESC");
    //betaalMethodes is an array with all possible payment methods that are in the table Betalingswijzen
    $betaalMethodes = SendToDatabase($betalingsMethodeQuery);
    //Create dictionary with all variables from the GET request. Dictionary is used to give all values to the query
    $Dictionary = array(
        'SearchKeyword' => $zoekterm,
        'SearchFilter' => $waardes[$sorteerfilter],
        'SearchPaymentMethod' => $betalingsmethode,
        'SearchCategory' => $rubriek,
        'SearchMinRemainingTime' => '',
        'SearchMaxRemainingTime' => '',
        'SearchMinPrice' => $prijs['min'],
        'SearchMaxPrice' => $prijs['max'],
        'ResultsPerPage' => $ResultsPerPage,
        'Offset' => $Offset,
        'SearchUser' => $user,
        'Pagenum' => $pagenum
    );
    foreach($Dictionary as $key => $value){
        $Dictionary[$key]= cleanInput(urldecode($Dictionary[$key]));
    }
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


    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/HomePage.css">
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" href="CSS/footer.css">

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
require('navbar.php');
?>

<!-- Filter bar -->
<div class="container-fluid">
    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <div class="list-group">
            <div class="list-group-item active">Sorteer Opties</div>
            <form method="get" action="resultaten.php" id="sorteerForm">
                <!-- Search on keyword -->
                <div class="list-group-item"> Zoekterm:
                    <div class="input-group" style="display:table;">
                        <input class="form-control" name="zoekterm" placeholder="Zoek hier"
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
                        $filterNamen = array("Tijd: nieuw aangeboden", "Tijd: eerst afgelopen", "Prijs: laagste bovenaan", "Prijs: hoogste bovenaan", "Gebruikerswaardering: hoogste bovenaan", "Gebruikerswaardering: laagste bovenaan","Aantal biedingen: hoogste aantal bovenaan", "Aantal biedingen: laagste aantal bovenaan", "Titel: A-Z", "Titel: Z-A");
                        if (isset($sorteerfilter)) {
                            echo "<option value=" . ($sorteerfilter) . " selected>" . $filterNamen[$sorteerfilter] . "</option>";
                            echo $filterNamen[$sorteerfilter];
                        }
                        //Creates all options in the array $filterNamen
                        for ($i = 0; $i < sizeof($filterNamen); $i++) {
                            if ($sorteerfilter != $i) {
                                echo "<option value=" . $i . ">" . $filterNamen[$i] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Price slider -->
                <div class="list-group-item">Prijs:
                    <b><?php echo('€' . $prijs['min'] . '- €' . $prijs['max']); ?></b>
                    <div>
                        <input id="pslider" type="text" name="prijs"
                               class="span1" value=""  style="width: 100%;"
                               data-slider-min="1"
                               data-slider-max="1000"
                               data-slider-step="5"
                        <?php
                        if (isset($prijs)) {
                            echo('data-slider-value="[' . $prijs['min'] . "," . $prijs['max'] . ']"/>');
                        } else {
                            echo('data-slider-value="[0,4500]"/>');
                        }
                        ?>
                    </div>
                <script>
                    var slider = new Slider('#pslider', {});
                </script>
                </div>

                <!-- Payment method select form -->

                <div class="list-group-item">Betalingsmethode:
                    <select class="form-control" name="betalingsmethode">
                        <?php
                        //Array to be able to create a for loop. When adding a new one nothing has to be changed this way.
                        if (empty($betalingsmethode)) {
                            echo "<option disabled selected>Maak uw keuze</option>";
                        } elseif (isset($betalingsmethode)) {
                            echo "<option value=" . $betalingsmethode . " selected>" . $betaalMethodes[$betalingsmethode]['BW_betalingswijze'] . "</option>";
                        }
                        //Creates all options in the array $filterNamen
                        for ($i = 0; $i < sizeof($betaalMethodes); $i++) {
                            if ($betalingsmethode != $i) {
                                echo "<option value=" . $i . ">" . $betaalMethodes[$i]['BW_betalingswijze'] . "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>

                <!-- Search ads by certain user -->

                <div class="list-group-item"> Gebruiker:
                    <div class="input-group">
                        <input class="form-control" name="user" placeholder="Zoek op gebruikers" value="<?php echo $user; ?>"
                               autocomplete="off"
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
                            <a style="color: #ffffff"
                               href="resultaten.php?zoekterm=<?php echo urldecode($zoekterm) ?> ">
                                <button class="btn btn-warning center-block btn-lg " type="button">
                                    <span class="glyphicon glyphicon-repeat"></span> Reset
                                </button>
                            </a>

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
                <input type="hidden" name="pagenum" value="1">

        </div>


        <!-- Categories -->

        <li class="list-group-item active" id="Header-Categories">
            <i class="text-right glyphicon glyphicon-th-list"></i>
            Rubrieken
        </li>
        <div class="list-group-item panel-collapse collapse in">
            <?php
            printCategories($zoekterm, $rubriekQuery, $rubriek, $sorteerfilter, $prijs, $betalingsmethode);
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

    <div class="col-md-8 col-sm-12 col-xs-12 right">
        <?php
        global $Dictionary;
        $result = SearchFunction($Dictionary);
        outputRows($result, $Dictionary["SearchKeyword"]);
        ?>

        <div class="col-md-5 col-sm-6 col-xs-6 col-md-push-5 col-sm-push-3 col-xs-push-3">
            <ul class="pagination">
                <?php
                drawPageNumbers($Dictionary, $result);
                ?>

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
</script>
<?php include('footer.html');?>
</body>
</html>
