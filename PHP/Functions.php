<?php

/*function for cleaning user input in order to attempt to prevent cross-site scripting/Html injection/sql injection */

/* intake:
 *  The uncleaned userinput
 *
 */


/* returns:
 *
 *  The cleaned input
 *
 */


function cleanInput($input)
{
    //strips any HTML tags
    $input = strip_tags($input);

    //removes any invisible characters (such as \n)
    $input = trim($input);

    //Replaces any ' with a '' such as to prevent breaking out of a string
    return $input = str_replace("'", "''", $input);
}


/* this function sends a prebuild query to the database and returns the result. */

/* intake:
 *
 *  Query
 *
 */


/* returns:
 *
 * 2D array of the result if succesfull
 * or a list with False and an error message.
 *
 */


function SendToDatabase($query)
{
    GLOBAL $connection;

    //tries to send the query and returns the response
    try {
        return $response = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);

        //if unsuccessful, returns a False as first item and the error as the second item in a list
    } catch (Exception $e) {
        return [False, 'Error: ' . $e->getMessage()];
    }
}

/* This function draws an auction */

/* intake:
 *
 *  array with auction info
 *
 */


/* returns:
 *
 *
 * HTML for an auction
 *
 */


function DrawAuction($auction)
{
    //testing for missing images and replacing with backup image
    if (empty($auction["ImagePath"])) {
        $auction["ImagePath"] = "images/no-image-available.jpg";
    }
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-3\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" .
        $auction["VW_titel"] . "
                    </div>
                    <div class=\"veiling-image\" style=\"background-image:url(" . $auction["ImagePath"] . ")\"></div>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . '<p id="timer' . $auction["VW_titel"] . '"></p>'. "</div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <button class=\"btn text-center btn-default bied\">Meer info</button>
                        <button class=\"btn text-center btn-info bied\">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
            
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"]);

}

function DrawSearchResults($auction)
{

    //testing for missing images and replacing with backup image
    if (empty($auction["ImagePath"])) {
        $auction["ImagePath"] = "images/no-image-available.jpg";
    }
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-md-4 col-sm-6 col-xs-6\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" .
        $auction["VW_titel"] . "
                    </div>
                    <div class=\"veiling-image\" style=\"background-image:url(" . $auction["ImagePath"] . ")\"></div>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . '<p id="timer' . $auction["VW_titel"] . '"></p>'. " </div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <button class=\"btn text-center btn-default bied\">Meer info</button>
                        <button class=\"btn text-center btn-info bied\">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"]);

}


function outputRows($result, $zoekterm)
{
    global $zoekterm;
    if (empty($result)) {
        echo "Geen resultaten gevonden voor: '" . $zoekterm . "'";
    } else {
        foreach ($result as $auction) {
            DrawSearchResults($auction);
        }
    }
}

/*
 *
 *
 *  [0] => Array
        (
            [VW_voorwerpnummer] => 8
            [VW_titel] => Testproduct8
            [prijs] => 2670.00
            [tijd] => 344
            [Biedingen] => 16
            [ImagePath] => images/testImg8.jpg
        )
 *
 *
 */


/*Function to load the header letters for the categories*/
function laadLetters()
{
    //load the groups
    global $groups;
    if (isset($groups)) {
        //Check every letter
        $letters = range('A', 'Z');
        $eerstekeer = true;
        foreach ($letters as $letter) {
            foreach ($groups as $group) {
                //If it's the first one, create a letter
                if ($eerstekeer) {
                    //If there is a header with the letter create a link
                    if ($group['Hoofd_Naam'][0] == $letter) {
                        if ($letter != 'Z') {
                            echo('<a href = "#' . $letter . '">' . $letter . " - " . '</a>');
                            $eerstekeer = false;
                        } else {
                            echo('<a href = "#' . $letter . '">' . $letter . " " . '</a>');
                        }
                    }
                }
            }
            //If there is not, just place the letter
            if ($eerstekeer == true && $letter != 'Z') {
                echo($letter . " - ");
            } elseif ($eerstekeer == true) {
                echo($letter . " ");
            }
            $eerstekeer = true;
        }
    }
}

/* Zoekfilter - converteert input naar en query, stuurt results terug  */

function SearchFunction($SearchOptions)
{
    //preparing for query


//clean the input
    /*
    $SearchKeyword = cleanInput($SearchKeyword);
    $SearchPaymentMethod = cleanInput($SearchPaymentMethod);
    $SearchFilter = cleanInput($SearchFilter);
    $SearchCategory = cleanInput($SearchCategory);
    $SearchSubCategory = cleanInput($SearchSubCategory);
    $SearchSubSubCategory = cleanInput($SearchSubSubCategory);
    $SearchMaxRemainingTime = cleanInput($SearchMaxRemainingTime);
    $SearchMinRemainingTime = cleanInput($SearchMinRemainingTime);
    $SearchMinPrice = cleanInput($SearchMinPrice);
    $SearchMaxPrice = cleanInput($SearchMaxPrice);

    */

    $SearchKeyword = $SearchOptions['SearchKeyword'];
    $QuerySearchKeyword = "'%" . $SearchKeyword . "%'";
    $SearchPaymentMethod = $SearchOptions['SearchPaymentMethod'];
    $SearchFilter = $SearchOptions['SearchFilter'];
    $SearchCategory = $SearchOptions['SearchCategory'];
    $SearchSubCategory = $SearchOptions['SearchSubCategory'];
    $SearchSubSubCategory = $SearchOptions['SearchSubSubCategory'];
    $SearchMaxRemainingTime = $SearchOptions['SearchMaxRemainingTime'];
    $SearchMinRemainingTime = $SearchOptions['SearchMinRemainingTime'];
    $SearchMinPrice = $SearchOptions['SearchMinPrice'];
    $SearchMaxPrice = $SearchOptions['SearchMaxPrice'];


//Prepare the query
    $QuerySearchProducts = <<< EOT

SELECT
   DISTINCT VW_voorwerpnummer,
   VW_titel,
   (SELECT TOP 1 BOD_Bodbedrag
    FROM Bod
    WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                FROM Bod
                                WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
    ORDER BY BOD_Bodbedrag DESC)                        AS prijs,
    DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) AS tijd,
    (SELECT TOP 1 BES_filenaam
    FROM Bestand
    WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath,
    VW_looptijdStart, 
    VW_looptijdEinde,
   Voorwerp.VW_betalingswijze
 FROM Voorwerp
   inneR JOIN Bod
     ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
   INNER JOIN Voorwerp_Rubriek
     ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
   INNER JOIN Rubriek
     ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
   INNER JOIN Rubriek r1
     ON r1.RB_Nummer = Rubriek.RB_Parent
   INNER JOIN Rubriek r2
     ON r2.RB_Nummer = r1.RB_Parent
 WHERE r2.RB_Naam != 'root'
	AND ('$SearchKeyword' IS NULL OR VW_titel LIKE '%$SearchKeyword%')
	AND ($SearchMaxRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) <= $SearchMaxRemainingTime)
	AND ($SearchMinRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) >= $SearchMinRemainingTime)
	AND ($SearchMinPrice IS NULL OR (SELECT TOP 1 BOD_Bodbedrag
									FROM Bod
		                            WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
		                                                        FROM Bod
			                                                    WHERE BOD_voorwerpnummer = VW_voorwerpnummer
				                                                ORDER BY BOD_Bodbedrag DESC) AND
																BOD_voorwerpnummer = VW_voorwerpnummer
						               ORDER BY BOD_Bodbedrag DESC) >= $SearchMinPrice)
	AND ($SearchMaxPrice IS NULL OR (SELECT TOP 1 BOD_Bodbedrag
			                       FROM Bod
		                           WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                                                           FROM Bod
                                                           WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                                           ORDER BY BOD_Bodbedrag DESC)
													 AND BOD_voorwerpnummer = VW_voorwerpnummer
									 ORDER BY BOD_Bodbedrag DESC) <= $SearchMaxPrice)
	AND ($SearchCategory IS NULL OR r2.RB_Nummer = $SearchCategory)
	AND ($SearchSubCategory IS NULL OR r1.RB_Nummer = $SearchSubCategory)
	AND ($SearchSubSubCategory IS NULL OR Rubriek.RB_Nummer = $SearchSubSubCategory)
	AND ($SearchPaymentMethod IS NULL OR Voorwerp.VW_betalingswijze = '$SearchPaymentMethod')
	AND (VW_veilinggesloten != 1)
GROUP BY VW_voorwerpnummer, VW_titel, Rubriek.RB_Naam, VW_looptijdEinde, r1.RB_Naam, r2.RB_Naam, VW_betalingswijze,Voorwerp.VW_looptijdStart,
   Voorwerp.VW_looptijdEinde,VW_looptijdStart, VW_looptijdEinde
ORDER BY $SearchFilter , VW_voorwerpnummer

    
EOT;
//executing the query
    return SendToDatabase($QuerySearchProducts);


}


// Print landen in registratie.php
function printLanden($Landen)
{

    foreach ($Landen as $Land) {
        if ($Land['LAN_landcode'] == "NL") {
            $selected = 'selected="Nederland"';
        } else {
            $selected = '';
        }
        echo '<option value="' . $Land['LAN_landcode'] . '" ' . $selected . '>'
            . $Land['LAN_landnaam'] . '</option>';
    }
}

// Print vragen in registratie.php
function printVragen($Vragen)
{
    foreach ($Vragen as $Vraag) {
        echo '<option value="' . $Vraag['VR_vraagnummer'] . '">'
            . $Vraag['VR_tekstvraag'] . '</option>';
    }
}


function printCategoriën($zoekterm)
{
    global $connection;
    global $prijs;
    $categorieQuery = "select
                            distinct r2.RB_Naam as Hoofdcategorie,
                            count(r2.RB_Naam) as aantal,
                            r2.RB_Nummer as CategorieNummer
                            from Voorwerp
                            Inner join Voorwerp_Rubriek
                            on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                            Inner join Rubriek
                            on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                            Inner join Rubriek r1
                            on r1.RB_Nummer = Rubriek.RB_Parent
                            Inner join Rubriek r2
                            on r2.RB_Nummer = r1.RB_Parent
                            Where r2.RB_Naam != 'root' and Voorwerp.VW_titel like '%$zoekterm%'
                            GROUP BY r2.RB_Naam,r2.RB_Nummer
                            ORDER BY COUNT(r2.RB_Naam) desc";
    $categorieResult = $connection->query($categorieQuery)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categorieResult as $categorie) {
        $url = urlencode($categorie['CategorieNummer']);
        echo '
                    <li><label class="tree-toggle nav-header">' . $categorie["Hoofdcategorie"] . '   ' . '<span class="badge label-primary">' . $categorie["aantal"] . '</span>' . '</label>
                        <ul class="nav nav-list tree" style="display: none;">
                        ';
        $subCategorieQuery = "select
                                        distinct r1.RB_Naam as Subcategorie,
                                        r2.RB_Nummer as Hoofdcategorie,
                                        count(r1.RB_Naam) as aantal,
                                        r1.RB_Nummer as CategorieNummer
                                        from Voorwerp
                                        Inner join Voorwerp_Rubriek
                                        on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                                        Inner join Rubriek
                                        on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                                        Inner join Rubriek r1
                                        on r1.RB_Nummer = Rubriek.RB_Parent
                                        Inner join Rubriek r2
                                        on r2.RB_Nummer = r1.RB_Parent
                                        Where r2.RB_Naam != 'root' and Voorwerp.VW_titel like '%$zoekterm%' and r1.RB_Parent = " . $categorie["CategorieNummer"] . "
                                        GROUP BY r1.RB_Naam,r1.RB_Nummer, r2.RB_Naam, r2.RB_Nummer
                                        ORDER BY COUNT(r1.RB_Naam) desc";
        $subCategorieResult = $connection->query($subCategorieQuery)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subCategorieResult as $subCategorie) {
            echo '<li><label class="tree-toggle nav-header">' . $subCategorie["Subcategorie"] . '<span class="badge pull-right label-primary">' . $subCategorie["aantal"] . '</label>
                                <ul class="nav nav-list tree" style="display: none;">';
            $subSubCategorieQuery = "select
                distinct Rubriek.RB_Naam as Subsubcategorie,
                count(Rubriek.RB_Naam) as aantal,
                Rubriek.RB_Nummer as CategorieNummer
                from Voorwerp
                Inner join Voorwerp_Rubriek
                on Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
                Inner join Rubriek
                on Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
                Inner join Rubriek r1
                on r1.RB_Nummer = Rubriek.RB_Parent
                Inner join Rubriek r2
                on r2.RB_Nummer = r1.RB_Parent
                Where r2.RB_Naam != 'root'and Voorwerp.VW_titel like '%$zoekterm%' and Rubriek.RB_Parent = " . $subCategorie["CategorieNummer"] . "
                GROUP BY Rubriek.RB_Naam, Rubriek.RB_Nummer
                ORDER BY COUNT(Rubriek.RB_Naam) desc";
            $subSubCategorieResult = $connection->query($subSubCategorieQuery)->fetchAll(PDO::FETCH_ASSOC);
            foreach ($subSubCategorieResult as $subSubCategorie) {
                $cat1 = urlencode($categorie["CategorieNummer"]);
                $cat2 = urlencode($subCategorie["CategorieNummer"]);
                $cat3 = urlencode($subSubCategorie['CategorieNummer']);
                $zoek = urlencode($zoekterm);
                $sort = urlencode($_GET['sorteerfilter']);
                echo ' <li><a href=" ' . '?zoekterm=' . $zoek . '&categorie=' . $cat1 . '&subcategorie=' . $cat2 . '&subsubcategorie=' . $cat3 . '&sorteerfilter=' . $sort . '&prijs=' . $prijs['min'] . ',' . $prijs['max'] . '">' . $subSubCategorie["Subsubcategorie"] . '<span class="badge pull-right label-info">' . $subSubCategorie["aantal"] . '</span>' . '</a></li>';
            }
            echo '</ul>
                        </li>';
        }
        echo '
                        </ul>
                        </li>
                      <hr size="1">';
    }

}


function createTimer($tijd, $VW_Titel)
{


    echo '<script>
    // Set the date we\'re counting down to
    var ' . $VW_Titel . ' = new Date("' . $tijd . '").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = ' . $VW_Titel . ' - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        
        document.getElementById("timer' . $VW_Titel . '").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s" ;
        
        

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer' . $VW_Titel . '").innerHTML = "Veiling gesloten";
        }
    }, 1000)
</script>
';
}

?>

