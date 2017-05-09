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
            <img src="Images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <form class="navbar-form navbar-left">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="zoeken">
            </div>
            <button type="submit" class="btn btn-default hidden-sm hidden-xs"><i class="glyphicon glyphicon-search"></i>
            </button>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#AdvancedSearch">Advanced Search</button>
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

        <div class="col-md-3 visible-lg">
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
                <a href="#" class="list-group-item">Boeken</a>
                <a href="categorie.php" class="list-group-item active text-center">Meer catogorieën <i
                        class="text-right glyphicon glyphicon-plus-sign"></i></a>
            </div>
        </div>


        <!--Carousel -->

        <div class="col-md-6 col-sm-9 col-xs-9">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <p class="Voorwerp-text"
                           style="text-align: center; font-size: 24px; background: #524BAB; color: white; ">Tesla Model
                            S 95D 20.000 </p>
                        <div><img class="Carousel-image" src="Images/ModelS.jpeg" alt="Model S"></div>
                    </div>

                    <div class="item">
                        <p class="Voorwerp-text"
                           style="text-align: center; font-size: 24px; background: #524BAB; color: white; ">Tesla Model
                            3 2018 goed als nieuw</p>
                        <div><img class="Carousel-image" src="Images/ModelX.jpeg" alt="Model X"></div>
                    </div>

                    <div class="item">
                        <div>
                            <p class="Voorwerp-text"
                               style="text-align: center; font-size: 24px; background: #524BAB; color: white; ">Tesla
                                Model X refurbished</p>
                            <img class="Carousel-image" src="Images/Model3.jpeg" alt="Model 3">
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


        <!-- Bijna gesloten veilingen -->


        <div class="col-md-3 visible-md visible-lg">

            <div class="list-group">
                <a href="#" class="list-group-item active text-center">Veiling gaat sluiten</a>
            </div>


            <div class="well col-xs-12">

                <!-- Veiling template -->
                <div class="veiling-rand col-md-12">
                    <div class="veiling">
                        <div class="veiling-titel label label-info">
                            Gratis Model S
                        </div>
                        <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
                        <div class="veiling-prijs-tijd">
                            <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                            <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                        </div>
                    </div>
                </div>
                <!-- End template -->

                <!-- Veiling template -->
                <div class="veiling-rand col-md-12">
                    <div class="veiling">
                        <div class="veiling-titel label label-info">
                            Gratis Model S
                        </div>
                        <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
                        <div class="veiling-prijs-tijd">
                            <div class="prijs label label-default"><i class="glyphicon glyphicon-euro"></i> 150000</div>
                            <div class="tijd label label-default">1:15:25 <i class="glyphicon glyphicon-time"></i></div>
                        </div>
                </div>
                <!-- End template -->

            </div>

        </div>
    </div>
</div>

        <!-- Extra advertenties -->

    <div class="container-fluid">
        <div class="row well">
            <!-- Veiling template -->
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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
            <div class="veiling-rand col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="veiling">
                    <div class="veiling-titel label label-info">
                        Gratis Model S
                    </div>
                    <div class="veiling-image" style="background-image:url(Images/ModelS.jpeg)"></div>
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

</body>
</html>