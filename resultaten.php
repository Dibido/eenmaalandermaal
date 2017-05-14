<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Resultaten</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">

    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- price slider -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/css/bootstrap-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/bootstrap-slider.js"></script>


    <!-- CSS -->
    <link rel="stylesheet" href="CSS/categorie-old.css">
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">
    <link rel="stylesheet" type="text/css" href="CSS/resultaten.css">

</head>

<body>

<!-- Navigation -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">
            <img src="images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <form class="navbar-form navbar-left">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="zoeken">
            </div>
            <button type="submit" class="btn btn-default hidden-sm hidden-xs"><i class="glyphicon glyphicon-search"></i>
            </button>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#AdvancedSearch">Advanced
                Search
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

                <a href="#" class="list-group-item">Prijs: <b>€ 10 - € 1000</b> <input id="pslider" type="text"
                                                                                       class="span2" value=""
                                                                                       data-slider-min="10"
                                                                                       data-slider-max="1000"
                                                                                       data-slider-step="5"
                                                                                       data-slider-value="[150,450]"/>
                </a>

                <a href="#" class="list-group-item">Rating: <b>1</b>
                    <select>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <a href="#" class="list-group-item">Afstand: <b>10KM - 100KM</b> <input id="aslider" type="text"
                                                                                            class="span2" value=""
                                                                                            data-slider-min="10"
                                                                                            data-slider-max="500"
                                                                                            data-slider-step="5"
                                                                                            data-slider-value="[10,100]"/>
                    </a>

                    <script>
                        var slider = new Slider('#pslider', {});
                        var slider = new Slider('#aslider', {});
                    </script>
                    <a href="#" class="list-group-item active" style="background-color: #524bab; text-align: center;" )>
                        Aanpassen
                    </a>

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
    <div class="col-md-9">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Resultaten</li>

            <div class="pull-right">
                <b>Sorteer:</b>
                <select id="example">
                    <option value="1">Tijd: nieuw aangeboden</option>
                    <option value="2">Tijd: eerst afgelopen</option>
                    <option value="3">Prijs: laagste bovenaan</option>
                    <option value="4">Prijs: hoogste bovenaan</option>
                    <option value="5">Afstand: dichtstbijzijnde eerst</option>
                </select>
            </div>
        </ol>
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
        require 'PHP/connection.php';
       global $zoekterm;
       $zoekterm = $_GET['zoekterm'];
        if (!empty($zoekterm)) {
            //bouwen query
            $sql = "SELECT  * FROM Voorwerp v LEFT JOIN Bod b ON v.VW_voorwerpnummer = b.BOD_voorwerpnummer 
                              WHERE (B.BOD_bodbedrag = (SELECT TOP 1 BOD_Bodbedrag 
                                                        FROM Bod 
                                                        WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag 
                                                                                    FROM Bod WHERE BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) OR b.BOD_bodbedrag IS NULL) 
                                    AND VW_titel LIKE '%$zoekterm%'";
            $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            outputRows($result);
        }


        function outputRows($result)
        {

    if (empty($result)) { 
            echo "Geen resultaten voor: $zoekterm "  ; 
            } 

            foreach ($result as $row) {
                $titel=$row['VW_titel'];
                $beschrijving=$row['VW_beschrijving'];
                $bodBedrag=$row['BOD_bodbedrag'];
                $tijd=$row['VW_looptijdEinde']-$row['VW_looptijdStart'];


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


</div>


</body>
</html>

