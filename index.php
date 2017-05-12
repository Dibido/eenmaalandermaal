<!doctype html>

<!-- onzin comment voor pushes -->

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Bootstrap test</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">


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

<?php





?>


<!-- Navigation -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">
            <img src="images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <form class="navbar-form navbar-left" action='resultaten.php' method='GET'>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="zoeken" name="zoekterm">
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
                <a href="#" class="list-group-item">Auto's</a>
                <a href="#" class="list-group-item">Electronica</a>
                <a href="#" class="list-group-item">Boeken</a>
                <a href="#" class="list-group-item">Vestibulum at eros</a>
                <a href="#" class="list-group-item">Electronica</a>
                <a href="#" class="list-group-item">Boeken</a>
                <a href="#" class="list-group-item">Vestibulum at eros</a>
                <a href="#" class="list-group-item">Electronica</a>
                <a href="#" class="list-group-item">Boeken</a>
                <a href="#" class="list-group-item">Vestibulum at eros</a>
                <a href="#" class="list-group-item">Electronica</a>
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
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="veiling-titel-carousel text-center"><p>Mooie Tesla Model S</p></div>
                            <div class="veiling-image-carousel" style="background-image:url(images/16-9.jpeg)"></div>
                            <div class="veiling-titel-carousel-bottom text-center">
                                <div class="veiling-rating-bied label label-default">
                                    <div class="rating text-center">
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star-empty"></i>
                                    </div class="advert-info">
                                    <i class="glyphicon glypicon-euro">15000</i>
                                </div>
                            </div>

                        </div>

                        <div class="item">
                            <div class="veiling-titel-carousel text-center"><p>Mooie Tesla Model S</p></div>
                            <div class="veiling-image-carousel" style="background-image:url(images/16-9.jpeg)"></div>
                            <div class="veiling-titel-carousel-bottom text-center">
                                <div class="veiling-rating-bied label label-default">
                                    <div class="rating text-center">
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star-empty"></i>
                                    </div class="advert-info">
                                    <i class="glyphicon glypicon-euro">15000</i>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="veiling-titel-carousel text-center"><p>Mooie Tesla Model S</p></div>
                            <div class="veiling-image-carousel"></div>
                            <div class="veiling-titel-carousel-bottom text-center">
                                <div class="veiling-rating-bied label label-default">
                                    <div class="rating text-center">
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star-empty"></i>
                                    </div class="advert-info">
                                    <i class="glyphicon glypicon-euro">15000</i>
                                </div>
                            </div>
                        </div>
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


                <!-- Veiling template -->
                <div class="veiling-rand col-md-12 col-sm-6 col-xs-6">
                    <div class="veiling">
                        <div class="veiling-titel label label-info">
                            Gratis Model S
                        </div>
                        <div class="veiling-image" style="background-image:url(images/ModelS.jpeg)"></div>
                        <div class="veiling-prijs-tijd">
                            <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                            <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                        </div>
                    </div>
                </div>
                <!-- End template -->


                <!-- Veiling template -->
                <div class="veiling-rand col-md-12 col-sm-6 col-xs-6">
                    <div class="veiling">
                        <div class="veiling-titel label label-info">
                            Gratis Model S
                        </div>
                        <div class="veiling-image" style="background-image:url(images/ModelS.jpeg)"></div>
                        <div class="veiling-prijs-tijd">
                            <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                            <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                        </div>
                    </div>
                </div>

                <!-- End template -->


            </div>
        </div>
    </div>

    <!-- Extra advertenties -->

    <div class="container-fluid">
        <div class="row well">

            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(images/16-9.jpeg)"></div>
                    <div class="veiling-prijs-tijd">
                        <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                        <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                    </div>
                    <div class="veiling-rating-bied label label-default">
                        <div class="rating text-center">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <button class="btn btn-primary bied">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->


        </div>
    </div>

    <-- Height corrections for carrousel -->
    <script>

        $(".Categoriën").css({'height': ($(".BijnaGesloten").height() + 'px')});
        $(".VeilingShowcase").css({'height': ($(".BijnaGesloten").height() + 'px')});

    </script>

</body>
</html>