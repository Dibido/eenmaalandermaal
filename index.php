<?php

require('PHP/connection.php');
require('PHP/Functions.php');
require('PHP/SQL-Querries.php');

$response = NULL;


/*
 *
 *      Getting the information for all the adverts from the database
 *
 *
 */



/* Getting the top 2 products that are almost closed en saving in $TopClosed */
$query = "
SELECT TOP 2
  --Vul hier je TOP X hoeveelheid in
  VW_voorwerpnummer,
  VW_titel,
  (SELECT TOP 1 BOD_Bodbedrag FROM Bod WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag FROM Bod WHERE BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer ORDER BY BOD_Bodbedrag DESC) as prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) AS tijd,
  COUNT(*)                                    AS Biedingen,
  (SELECT TOP 1 BES_filenaam from Bestand WHERE BES_voorwerpnummer = VW_voorwerpnummer) as ImagePath
FROM Voorwerp
  INNER JOIN BOD
    ON Voorwerp.VW_voorwerpnummer = BOD_voorwerpnummer
WHERE DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) < 1000 AND DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde) > 2 AND
      --Vul hier de minimum en maximum tijd over in
      VW_voorwerpnummer IN (SELECT BOD_voorwerpnummer
                            FROM Bod
                              LEFT JOIN Voorwerp_Rubriek
                                ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
                              LEFT JOIN Rubriek
                                ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                              LEFT JOIN Rubriek r1
                                ON r1.RB_Nummer = Rubriek.RB_Parent
                              LEFT JOIN Rubriek r2
                                ON r2.RB_Nummer = r1.RB_Parent
                            WHERE r2.RB_Naam IN (SELECT TOP 3
                                                   RB_Naam --Vul hier de top X categoriën in waarvan producten moeten worden laten zien.
                                                 FROM Rubriek
                                                   LEFT JOIN
                                                   (SELECT
                                                      Rubriek.RB_Parent,
                                                      aantal
                                                    FROM Rubriek
                                                      LEFT JOIN (SELECT
                                                                   RB_Parent,
                                                                   COUNT(BOD_voorwerpnummer) AS aantal
                                                                 FROM Voorwerp_Rubriek
                                                                   LEFT JOIN Rubriek
                                                                     ON Rubriek.RB_Nummer =
                                                                        Voorwerp_Rubriek.VR_Rubriek_Nummer
                                                                   LEFT JOIN Bod
                                                                     ON Voorwerp_Rubriek.VR_Voorwerp_Nummer =
                                                                        Bod.BOD_voorwerpnummer
                                                                 GROUP BY RB_Parent) eerste
                                                        ON Rubriek.RB_Volgnummer = eerste.RB_Parent
                                                    GROUP BY Rubriek.RB_Parent, aantal) tweede
                                                     ON Rubriek.RB_Volgnummer = tweede.RB_Parent
                                                 GROUP BY Rubriek.RB_Naam
                                                 ORDER BY MAX(aantal) DESC)
                            GROUP BY BOD_voorwerpnummer, r2.RB_Naam)
GROUP BY VW_voorwerpnummer, VW_looptijdEinde, VW_titel
ORDER BY Biedingen DESC

";

try {
    global $response;
    $response = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo('<h1>De top 2 producten kunnen niet opgehaald worden</h1>');
    echo('<p>Error: '. $e->getMessage() . '</p>');
}
    $TopClosed = $response;



/* Getting the top 3 uit belangrijkste categorie, hoogste rating en meeste biedingen en slaat op in $TopCarousel*/

$query = "
SELECT TOP 3
  VW_voorwerpnummer,
  VW_titel,
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                  AS prijs,
  DATEDIFF(HOUR, GETDATE(), VW_looptijdEinde)    AS tijd,
  COUNT(*)                                       AS Biedingen,
  (SELECT TOP 1 BES_filenaam
   FROM Bestand
   WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath
FROM Voorwerp
WHERE VW_voorwerpnummer IN (
  SELECT DISTINCT BOD_voorwerpnummer
  --Selecteerd de naam van de Hoofdcategorie per voorwerpnummer
  FROM Bod
    INNER JOIN Voorwerp_Rubriek
      ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
    INNER JOIN Rubriek
      ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
    INNER JOIN Rubriek r1
      ON r1.RB_Nummer = Rubriek.RB_Parent
    INNER JOIN Rubriek r2
      ON r2.RB_Nummer = r1.RB_Parent
  WHERE r2.RB_Naam != 'root' AND r2.RB_Naam IN (
    --Selecteerd de top 1 categoriën door te kijken naar de hoeveelheid biedingen
    SELECT
      TOP 1 RB_Naam
    FROM Rubriek
      --Lees de de Innerjoins van achter naar voren.
      INNER JOIN
      --Selecteerd de tweede laag van de categoriën
      (SELECT
         Rubriek.RB_Parent,
         aantal
       FROM Rubriek
         INNER JOIN
         --Selecteerd de hoeveelheid biedingen per categorie op de onderstelaag
         (SELECT
            RB_Parent,
            COUNT(BOD_voorwerpnummer) AS aantal
          FROM Voorwerp_Rubriek
            INNER JOIN Rubriek
              ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
            INNER JOIN Bod
              ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Bod.BOD_voorwerpnummer
          GROUP BY RB_Parent)
         eerste ON Rubriek.RB_Volgnummer = eerste.RB_Parent
       GROUP BY Rubriek.RB_Parent, aantal) tweede ON Rubriek.RB_Volgnummer = tweede.RB_Parent
    WHERE Rubriek.RB_Parent = 0
    GROUP BY Rubriek.RB_Naam
    ORDER BY MAX(aantal) DESC)
) --TODO AND Verkoper van voorwerp in top van de gebruikerreviews
GROUP BY VW_voorwerpnummer, VW_titel, VW_looptijdEinde
";

try {
    global $response;
    $response = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo('<h1>De top 2 producten kunnen niet opgehaald worden</h1>');
    echo('<p>Error: '. $e->getMessage() . '</p>');
}
$TopCarousel = $response;



?>

<!doctype html>

<!-- onzin comment voor pushes -->

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
    <link rel="stylesheet" href="CSS/veiling.css">
    <link rel="stylesheet" href="CSS/navigation.css">


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
                    <span class="input-group-addon" style="width:1%;"><span class="glyphicon glyphicon-search"></span></span>
                </div>
            </div>
        </form>

    </div>
</nav>

<!-- Advanced Search -->

<div class="container-fluid collapse" id="AdvancedSearch">
    <div class="col-xs-12">
        <h1>Zoek hier!</h1>

    </div>
</div>


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


<div class="container-fluid">
    <div class="row well">


        <!-- Categoriën -->

        <div class="col-md-3 visible-lg Categoriën" id="Categoriën">
            <div class="list-group">
                <a href="#" class="list-group-item active" id="Header-Categories">
                    Categorieën
                </a>
                <?php

                $TopCategories = SendToDatabase($QueryTopCategories);

                if($TopCategories[0]){
                    foreach($TopCategories as $Category){
                        echo"<a href=\"#\" class=\"list-group-item\">" . $Category['RB_Naam'] . "</a>";
                    }
                }else{
                    echo "<b>Error on loading categories: </b>" . "<br><br>" . $TopCategories[1];
                }


                ?>
                <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>
            </div>
        </div>


        <!-- Carousel -->

        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">

            <div class="list-group">
                <a href="#" class="list-group-item active text-center">Hot deals</a>
            </div>


            <div class="well">
                <div id="myCarousel" class="carousel slide VeilingShowcase" id="VeilingShowcase" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->

                    <?php
                    $BestFromCategories = SendToDatabase($QueryFromBestCategory);

                    //testing if the server returned an error
                    if ($BestFromCategories[0]){
                        //Searching for missing images and replacing with the backup image
                        foreach($BestFromCategories as $auction){
                            if(empty($auction["ImagePath"])){
                                $auction["ImagePath"] = "images/no-image-available.jpg";
                            }
                        }

                        echo "
                        
                        <div class=\"carousel-inner\">
                        <div class=\"item active\">
                            <div class=\"veiling-titel-carousel text-center\"><p>" . $BestFromCategories[0]["VW_titel"] . "</p></div>
                            <div class=\"veiling-image-carousel\"" . "style=\"background-image:url(" . $BestFromCategories[0]["ImagePath"] . ")\"></div>
                            <div class=\"veiling-titel-carousel-bottom text-center\">
                                <div class=\"veiling-rating-bied label label-default\">
                                    <div class=\"rating text-center\">
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star-empty\"></i>
                                    </div class=\"advert-info\">
                                    <i class=\"glyphicon glyphicon-euro\">" . $BestFromCategories[0]["prijs"] . "</i>
                                </div>
                            </div>
                        </div>

                        <div class=\"item\">
                            <div class=\"veiling-titel-carousel text-center\"><p>" . $BestFromCategories[1]["VW_titel"] . "</p></div>
                            <div class=\"veiling-image-carousel\"" . "style=\"background-image:url(" . $BestFromCategories[1]["ImagePath"] . ")\"></div>
                            <div class=\"veiling-titel-carousel-bottom text-center\">
                                <div class=\"veiling-rating-bied label label-default\">
                                    <div class=\"rating text-center\">
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star-empty\"></i>
                                    </div class=\"advert-info\">
                                    <i class=\"glyphicon glyphicon-euro\">" . $BestFromCategories[1]["prijs"] . "</i>
                                </div>
                            </div>
                        </div>

                        <div class=\"item\">
                            <div class=\"veiling-titel-carousel text-center\"><p>" . $BestFromCategories[2]["VW_titel"] . "</p></div>
                            <div class=\"veiling-image-carousel\"" . "style=\"background-image:url(" . $BestFromCategories[2]["ImagePath"] . ")\"></div>
                            <div class=\"veiling-titel-carousel-bottom text-center\">
                                <div class=\"veiling-rating-bied label label-default\">
                                    <div class=\"rating text-center\">
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star\"></i>
                                        <i class=\"glyphicon glyphicon-star-empty\"></i>
                                    </div class=\"advert-info\">
                                    <i class=\"glyphicon glyphicon-euro\">" . $BestFromCategories[2]["prijs"] . "</i>
                                </div>
                            </div>
                        </div>
                        
                        ";
                    }else{
                        echo "<b>Error on loading best auctions: </b>" . "<br><br>" . $BestFromCategories[1];
                    }

                    ?>

                </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>


        <!-- Bijna gesloten veilingen -->


        <div class="col-md-3 col-sm-12 col-xs-12">

            <div class="list-group">
                <a href="#" class="list-group-item active text-center">Veiling gaat sluiten</a>
            </div>


            <div class="well col-xs-12 BijnaGesloten" id="BijnaGesloten">


                <?php

                /* Printing the top 2 almost closed auctions*/

                $TopClosed = SendToDatabase($QueryTop2);

                //If the query was succesfull, build the adverts
                if ($TopClosed[0]) {

                    foreach ($TopClosed as $veiling) {
                        echo "<div class=\"veiling-rand col-md-12 col-sm-6 col-xs-6\">
                    <div class=\"veiling\">
                        <div class=\"veiling-titel label label-info\">"
                            . $veiling["VW_titel"] .
                            "</div>
                        <div class=\"veiling-image\"";

                        if (!empty($veiling["ImagePath"])) {

                            echo "style=\"background-image:url(" . $veiling["ImagePath"] . ")\"></div>
                                    <div class=\"veiling-prijs-tijd\">
                                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $veiling["prijs"] . "</div>
                                        <div class=\"tijd label label-default\">" . $veiling["tijd"] . "<i class=\"glyphicon glyphicon-time\"></i></div>
                                    </div>
                                </div>
                            </div>";

                        } else {
                            echo "></div>
                                    <div class=\"veiling-prijs-tijd\">
                                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $veiling["prijs"] . "</div>
                                        <div class=\"tijd label label-default\">" . $veiling["tijd"] . " <i class=\"glyphicon glyphicon-time\"></i></div>
                                    </div>
                                </div>
                            </div>";
                        }
                    }

                //if not, return the error
                }else{
                    echo "<b>Error on loading almost closed auctions: </b>" . "<br><br>" . $TopClosed[1];
                }



                ?>


            </div>
        </div>
    </div>

    <!-- Extra advertenties -->

    <div class="container-fluid">
        <div class="row well">

            <?php

            $auctions = SendToDatabase($QueryQualityNew);
            if($auctions[0]){
                foreach($auctions as $auction){
                    DrawAuction($auction);
                }
            }else{
                echo "<b>Error on loading auctions: </b>" . "<br><br>" . $auctions[1];
            }


            ?>


        </div>
    </div>

    <!-- Height corrections for carrousel -->
    <script>

        $(".Categoriën").css({'height': ($(".BijnaGesloten").height() + 'px')});
        $(".VeilingShowcase").css({'height': ($(".BijnaGesloten").height() + 'px')});

    </script>

</body>
</html>