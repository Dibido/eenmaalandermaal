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
    <link rel="stylesheet" href="CSS/categorie.css">
</head>

<body>

<div class="row">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="Images/Site-logo.png" class="">
                </a>
                <form class="navbar-form col-sm-8 text-center" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Zoek</button>
                </form>
            </div>
        </div>
    </nav>
</div>

<!--TODO: Zorgen dat wells van de categorieen naast de linker balk komen te staan.-->
<div class="row">
    <div class="col-md-2">
        <div class="container-fluid">
            <div class="visible-lg visible-md visible-sm visible-xs">
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        Auto onderdelen
                    </a>
                    <a href="#" class="list-group-item">Accu's</a>
                    <a href="#" class="list-group-item">Uitlaatpijpen</a>
                    <a href="#" class="list-group-item">Remblokken</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Auto onderdelen</li>
        </ol>
    </div>
    <div class="container-fluid">
        <div class="well well-lg col-md-10 col-sm-8">
            <h2>Trending</h2>
            <div class="voorwerp well well-sm col-md-2 col-sm-2 col-xs-1">
                <h5>Tesla X</h5>
                <img src="Images/ModelX.jpeg" height="100" width="220">
                <span class="well well-sm glyphicon glyphicon-euro" aria-hidden="true">15.00</span>
                <span class="well well-sm glyphicon glyphicon-time" aria-hidden="true">1:15:35</span>
                <div class="well well-sm">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                </div>
                <button class="btn btn-primary">Bied Nu!</button>
            </div>
            <div class="voorwerp well well-sm col-md-2">
                <h5>Aanbieding#2</h5>
            </div>
            <div class="voorwerp well well-sm col-md-2">
                <h5>Aanbieding#3</h5>
            </div>
            <div class="voorwerp well well-sm col-md-2">
                <h5>Aanbieding#4</h5>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="well well-lg col-md-10">
            <h2>Accu's</h2>
            <div class="voorwerp well well-sm col-md-2">
                <h5>Tesla X</h5>
                <img src="Images/ModelS.jpeg" height="100" width="220">
                <span class="glyphicon glyphicon-euro" aria-hidden="true">15.00</span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
            </div>
            <div class="voorwerp well well-sm col-md-2 col-md-offset-1">
                <h5>Aanbieding#2</h5>
            </div>
            <div class="voorwerp well well-sm col-md-2 col-md-offset-1">
                <h5>Aanbieding#3</h5>
            </div>
            <div class="voorwerp well well-sm col-md-2 col-md-offset-1">
                <h5>Aanbieding#4</h5>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<?php
//TODO: add database queries and formatting.
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //TODO: get category
}
?>