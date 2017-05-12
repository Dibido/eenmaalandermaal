<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Categorie</title>
    <meta name="description" content="EenmaalAndermaal">
    <meta name="author" content="Iproject - Groep 3">

    <!-- bootstrap !-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/categorie-old.css">
    <link rel="stylesheet" href="CSS/advert.css">
    <link rel="stylesheet" href="CSS/BootstrapXL.css">
    <link rel="stylesheet" href="CSS/theme.css"
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
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#AdvancedSearch"><i
                        class="glyphicon glyphicon-menu-down"></i></button>
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

<!-- Category bar -->

<div class="container-fluid">
    <div class="col-md-2">
        <div class="visible-lg visible-md visible-sm visible-xs">
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    Auto onderdelen
                </a>
                <a href="#" class="list-group-item">Accu's</a>
                <a href="#" class="list-group-item">Uitlaatpijpen</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
                <a href="#" class="list-group-item">Remblokken</a>
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Auto onderdelen</li>
        </ol>
    </div>

    <!-- Trending items -->

    <div class="well well-sm col-md-10 pull-right">
        <h2>Trending</h2>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
            <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
        <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
            <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
            <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
        <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
        <div class="advert col-xl-3 col-md-4 col-sm-6 col-xs-6 text-center">
            <div class="title">
                <h5>Tesla X 150000km 2012 als nieuw fkl...</h5>
            </div>
            <div class="advert-img thumbnail center-block">
                <img class="img-responsive" src="images/Roadster.jpg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro prijs" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time tijd" aria-hidden="true">1:15:25</span>
            <div>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
        </div>
    </div>

    <!-- Subcategories -->
    <div class="well well-sm col-md-10 pull-right">
        <h2>Accu's</h2>
        <div class="advert col-md-3 col-xs-6 text-center">
            <h5>Tesla X</h5>
            <div class="advert-img thumbnail">
                <img class="img-responsive center-block" src="images/ModelS.jpeg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:25</span>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <button class="btn btn-primary">Bied Nu!</button>
        </div>
        <div class="advert col-md-3 col-xs-6 text-center">
            <h5>Tesla X</h5>
            <div class="advert-img thumbnail">
                <img class="img-responsive center-block" src="images/ModelS.jpeg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:25</span>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <button class="btn btn-primary">Bied Nu!</button>
        </div>
        <div class="advert col-md-3 col-xs-6 text-center">
            <h5>Tesla X</h5>
            <div class="advert-img thumbnail">
                <img class="img-responsive center-block" src="images/ModelS.jpeg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:25</span>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <button class="btn btn-primary">Bied Nu!</button>
        </div>
        <div class="advert col-md-3 col-xs-6 text-center">
            <h5>Tesla X</h5>
            <div class="advert-img thumbnail">
                <img class="img-responsive center-block" src="images/ModelS.jpeg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:25</span>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <button class="btn btn-primary">Bied Nu!</button>
        </div>
        <div class="advert col-md-3 col-xs-6 text-center">
            <h5>Tesla X</h5>
            <div class="advert-img thumbnail">
                <img class="img-responsive center-block" src="images/ModelS.jpeg">
            </div>
            <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">1500000.00</span>
            <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:25</span>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <button class="btn btn-primary">Bied Nu!</button>
        </div>
    </div>
</div>
</body>
</html>

<?php
//TODO: add database queries and formatting.
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //TODO: get category
    /*if(isset(_GET["cat"])){
    $category = _GET[0];
    };*/
}
?>