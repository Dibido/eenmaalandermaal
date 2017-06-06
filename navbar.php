<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand">
            <img src="images/testlogo.png" alt="EenmaalAndermaal Logo">
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav collapse navbar-collapse">
                <li>
                    <button class="btn btn-default navbar-btn hidden-md hidden-lg MobileButtonToggle"
                            data-toggle="collapse"
                            data-target="#MobileButtons"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
                </li>
                <li>
                    <button class="btn btn-primary navbar-btn hidden-sm hidden-xsv NavLeftButton">Plaats veiling
                    </button>
                </li>
                <li>
                    <button class="btn btn-default navbar-btn hidden-sm hidden-xsv NavRightButton"
                            data-toggle="collapse" data-target="#accountControls">
                        <i class="glyphicon glyphicon-user"></i>
                    </button>
                </li>
            </ul>
        </div>


        <form class="navbar-form" action="resultaten.php" method="GET">
            <div class="form-group" style="display:inline;">
                <div class="input-group" style="display:table;">
                    <input class="form-control" name="zoekterm" placeholder="Zoek hier" autocomplete="off"
                           autofocus="autofocus" type="text">
                    <span class="input-group-btn" id="sizing-addon1" style="width:1%;"><button class="btn btn-secondary"
                                                                                               type="submit"
                                                                                               style="background-color: #ffffff; border-color: #f2f2f2;"><span
                                    class="glyphicon glyphicon-search"></span></button></span>
                </div>
            </div>
        </form>
    </div>
</nav>


<?php
session_start();
if (isset($_SESSION['Username'])) {
    //echo 'U bent ingelogd';
    echo '<div class="collapse text-center" id="accountControls">
    <div class="list-group">
        <a href="profiel.php" class="list-group-item">Mijn account</a>
        <a href="../login.php?loggedOut=True" class="list-group-item">Log out</a>
    </div>
</div>';
} elseif (isset($_SESSION['adminUsername'])){
    echo '<div class="collapse text-center" id="accountControls">
    <div class="list-group">
        <a href="http://iproject3.icasites.nl/profiel.php" class="list-group-item">Mijn account</a>
        <a href="http://iproject3.icasites.nl/BeheerLogin.php?loggedOut=True" class="list-group-item">Log out</a>
    </div>
</div>';

} else {
    //echo 'U bent niet ingelogd';
    echo '<div class="collapse text-center" id="accountControls">
    <div class="list-group">
        <a href="login.php" class="list-group-item">Log In</a>
        <a href="registreer1.php" class="list-group-item">Registreer</a>
    </div>
</div>';
}
?>









