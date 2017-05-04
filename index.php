<!doctype html>


<html lang="en">

    <head>
        <meta charset="utf-8">

        <title>Bootstrap test</title>
        <meta name="description" content="EenmaalAndermaal">
        <meta name="author" content="Iproject - Groep 3">


        <!-- bootstrap !-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="CSS/HomePage.css">

    </head>

    <body>

    <div class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand navbar-left"><img src="Images/Site-logo.png" alt="EenmaalAndermaal logo"></a>
            <ul class="nav navbar-nav">
                <li>
                    <form class="navbar-form navbar-center" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">zoek</button>
                    </form>
                </li>
                <li>
                    <button type="button" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-menu-down"></i></button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary navbar-btn">Plaats veiling</button>
                </li>
                <li>
                    <a><i class="glyphicon glyphicon-user"></i></a>
                </li>
            </ul>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row well">

            <div class="col-md-2 hvisible-md visible-lg">
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        Categories
                    </a>
                    <a href="#" class="list-group-item">Auto's</a>
                    <a href="#" class="list-group-item">Electronica</a>
                    <a href="#" class="list-group-item">Boeken</a>
                    <a href="#" class="list-group-item">Vestibulum at eros</a>
                </div>
            </div>

            <div class="col-md-8">
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
                            <img class="img-responsive center-block" src="Images/ModelS.jpeg" alt="Los Angeles">
                        </div>

                        <div class="item">
                            <img class="img-responsive center-block" src="Images/ModelX.jpeg" alt="Chicago" style="width:100%;">
                        </div>

                        <div class="item">
                            <img class="img-responsive center-block" src="Images/Model3.jpeg" alt="New york" style="width:100%;">
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

            <div class="col-md-2">

            </div>

        </div>
    </div>


    </body>
</html>