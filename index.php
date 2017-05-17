<?php

require('PHP/connection-old.php');
require('PHP/Functions.php');
require('PHP/SQL-Queries.php');

$response = NULL;

?>

<!doctype html>

<!-- onzin comment voor pushes nr2 -->

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

<?php
require('navbar.html');
?>


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
    <div class="row">


        <!-- Categoriën -->

        <div class="col-md-3 visible-lg Categoriën" id="Categoriën">
            <div class="list-group">
                <a href="#" class="list-group-item active" id="Header-Categories">
                    Top 10 categorieën
                </a>
                <?php

                $TopCategories = SendToDatabase($QueryTopCategories);

                if ($TopCategories[0]) {
                    foreach ($TopCategories as $Category) {
                        echo "<a href=\"#\" class=\"list-group-item\">" . $Category['RB_Naam'] . "</a>";
                    }
                } else {
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
                <a href="#" class="list-group-item active text-center">Veilingen uit populaire categorie</a>
            </div>


            <div>
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
                    if ($BestFromCategories[0]) {
                        //Searching for missing images and replacing with the backup image
                        foreach ($BestFromCategories as $auction) {
                            if (empty($auction["ImagePath"])) {
                                $auction["ImagePath"] = "images/no-image-available.jpg";
                            }
                        }

                        echo "
                        
                        <div class=\"carousel-inner\">
                        <div class=\"item active\">
                            <div class=\"veiling-titel-carousel text-center\"><p>" . $BestFromCategories[0]["VW_titel"] . "</p></div>
                            <div class=\"veiling-image-carousel\"" . " style=\"background-image:url(" . $BestFromCategories[0]["ImagePath"] . ")\"></div>
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
                            <div class=\"veiling-image-carousel\"" . " style=\"background-image:url(" . $BestFromCategories[1]["ImagePath"] . ")\"></div>
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
                            <div class=\"veiling-image-carousel\"" . " style=\"background-image:url(" . $BestFromCategories[2]["ImagePath"] . ")\"></div>
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
                    } else {
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


        <div class=" col-xs-12 BijnaGesloten" id="BijnaGesloten">


            <?php

            /* Printing the top 2 almost closed auctions*/

            $TopClosed = SendToDatabase($QueryTop2);

            //If the query was succesfull, build the adverts
            if ($TopClosed[0]) {

                foreach ($TopClosed as $veiling) {
                    echo "<div class=\"veiling-rand col-md-12 col-sm-6 col-xs-6\">
                    <div class=\"veiling\">
                        <div class=\"veiling-titel label label-default\">"
                        . $veiling["VW_titel"] .
                        "</div>
                        <div class=\"veiling-image\" ";

                    if (!empty($veiling["ImagePath"])) {

                        echo "style=\"background-image:url(" . $veiling["ImagePath"] . ")\"></div>
                            <div class=\"veiling-prijs-tijd\">
                                <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $veiling["prijs"] . "</div>
                                <div class=\"tijd label label-default\">" . $veiling["tijd"] . "<i class=\"glyphicon glyphicon-time\"></i></div>
                            </div>
                         </div>
                     </div>";

                    } else {
                        echo ">
                            </div>
                                <div class=\"veiling-prijs-tijd\">
                                    <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $veiling["prijs"] . "</div>
                                    <div class=\"tijd label label-default\">" . $veiling["tijd"] . " <i class=\"glyphicon glyphicon-time\"></i></div>
                                </div>
                            </div>
                        </div>";
                    }
                }

                //if not, return the error
            } else {
                echo "<b>Error on loading almost closed auctions: </b>" . "<br><br>" . $TopClosed[1];
            }


            ?>


        </div>
    </div>
</div>

<!-- Extra advertenties -->

        <div class="col-sm-12 HeaderTitle text-center">Populaire nieuwe veilingen</div>

        <?php


        /*
        $StommeDictionary = array(
           'SearchKeyword' => 'testproduct3',
            'SearchFilter' => 'NULL',
            'SearchPaymentMethod' => 'NULL',
            'SearchCategory' => 'NULL',
            'SearchSubCategory' => 'NULL',
            'SearchSubSubCategory' => 'NULL',
            'SearchMaxRemainingTime' => 'NULL',
            'SearchMinRemainingTime' => 'NULL',
            'SearchMinPrice' => 'NULL',
            'SearchMaxPrice' => 'NULL'
        );

        $QualityNewAuctions = sen($QueryQualityNew);

        */

        $ExtraAuctions = SendToDatabase($QueryQualityNew);

        if ($ExtraAuctions[0]) {
            foreach ($ExtraAuctions as $advert) {
                DrawAuction($advert);
            }
        } else {
            echo "<b>Error on loading auctions: </b>" . "<br><br>" . $ExtraAuctions[1];
        }

        ?>


</div>

<div class="container-fluid" style="width: 100%; height: 300px; background-color: #F6D155; border-top: 4px solid #F6B555">
    <div class="col-md-3 center-block">
        <ul class="list-unstyled">

        </ul>
    </div>

</div>

<!-- Height corrections for carrousel -->
<script>

    $(".Categoriën").css({'height': ($(".BijnaGesloten").height() + 'px')});
    $(".VeilingShowcase").css({'height': ($(".BijnaGesloten").height() + 'px')});

</script>

</body>
</html>