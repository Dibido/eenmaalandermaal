<!doctype html>


<html lang="en">

    <head>
        <meta charset="utf-8">

        <title>Bootstrap test</title>
        <meta name="description" content="EenmaalAndermaal">
        <meta name="author" content="Iproject - Groep 3">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="CSS/HomePage.css">

    </head>

    <body>

        <nav class="navbar navbar-default">
            <div class="row">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">
                         <img alt="Brand" src="Images/Site-logo.png" class="">
                        </a>
                        <form class="navbar-form col-sm-8 text-center" role="search">
                          <div class="form-group">
                              <input type="text" class="form-control" placeholder="Search">
                          </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        </div class="row">
            <div class="container">

                <div class="col-md-2">

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
                                <img src="la.jpg" alt="Los Angeles">
                            </div>

                            <div class="item">
                                <img src="chicago.jpg" alt="Chicago">
                            </div>

                            <div class="item">
                                <img src="ny.jpg" alt="New York">
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

                    <div class="col-md-2">
                        
                    </div>

                </div>
            </div>
        <div>

        </div>
    </body>

</html>