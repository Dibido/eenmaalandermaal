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
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/css/bootstrap-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.0/bootstrap-slider.js"></script>
    

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/categorie-old.css">
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

                <a href="#" class="list-group-item">Prijs: <b>€ 10 - € 1000</b> <input id="pslider" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[150,450]"/> </a>

                 <a href="#" class="list-group-item">Rating: <b>1</b> 
                    <select id="example">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
 
                <a href="#" class="list-group-item">Afstand: <b>10KM - 100KM</b> <input id="aslider" type="text" class="span2" value="" data-slider-min="10" data-slider-max="500" data-slider-step="5" data-slider-value="[10,100]"/> </a>

                    <script>
                    var slider = new Slider('#pslider', {});
                    var slider = new Slider('#aslider', {});
                    </script>
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
        </ol>
    </div>

    <!-- Trending items -->

    <div class="well well-sm col-md-9 pull-left">
        <h2>Resultaten</h2>
        <!-- Veiling template -->
<div class="veiling-rand col-xs-12 col-sm-5 col-md-3 col-lg-3 col-xl-2">
    <div class="veiling">
        <div class="veiling-titel label label-info">
            Gratis Model S
        </div>
        <div class="veiling-image" style="background-image:url(Images/16-9.jpeg)"></div>
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

             <ul class="pagination float-right">
                <li><a href="#">1</a></li>
                <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
            </ul>
    </div>
</div>

 



</body>
</html>

