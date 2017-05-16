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
            <div class=\"veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-info\">" .
        $auction["VW_titel"] . "
                    </div>
                    <div class=\"veiling-image\" style=\"background-image:url(" . $auction["ImagePath"] . ")\"></div>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . $auction["tijd"] . " <i class=\"glyphicon glyphicon-time\"></i></div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <div class=\"rating text-center\">
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star-empty\"></i>
                        </div>
                        <button class=\"btn btn-primary bied\">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
    ";
}

function DrawSearchResults($auction)
{

    //testing for missing images and replacing with backup image
    if (empty($auction["ImagePath"])) {
        $auction["ImagePath"] = "images/no-image-available.jpg";
    }
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-md-4 col-sm-6\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-info\">" .
        $auction["VW_titel"] . "
                    </div>
                    <div class=\"veiling-image\" style=\"background-image:url(" . $auction["ImagePath"] . ")\"></div>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . $auction["tijd"] . " <i class=\"glyphicon glyphicon-time\"></i></div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <div class=\"rating text-center\">
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star\"></i>
                            <i class=\"glyphicon glyphicon-star-empty\"></i>
                        </div>
                        <button class=\"btn btn-primary bied\">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
    ";
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
    print_r($SearchOptions);
    //preparing for query
    foreach($SearchOptions AS $SearchOption){
        if($SearchOptions = 'NULL'){
            $SearchOptions[$SearchOption] = str_replace("'", "", $SearchOption);
        }
    }

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
    $QuerySearchKeyword =  "'%" . $SearchKeyword . "%'";
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
    WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                                FROM Bod
                                WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
    ORDER BY BOD_Bodbedrag DESC)                        AS prijs,
    DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) AS tijd,
    (SELECT TOP 1 BES_filenaam
    FROM Bestand
    WHERE BES_voorwerpnummer = VW_voorwerpnummer) AS ImagePath,
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

	AND ('$SearchKeyword' IS NULL OR VW_titel LIKE $QuerySearchKeyword)
	AND ('$SearchMaxRemainingTime' IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) <= '$SearchMaxRemainingTime')
	AND ('$SearchMinRemainingTime' IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) >= '$SearchMinRemainingTime')
	AND ('$SearchMinPrice' IS NULL OR (SELECT TOP 1 BOD_Bodbedrag
									FROM Bod
		                            WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
		                                                        FROM Bod
			                                                    WHERE BOD_voorwerpnummer = VW_voorwerpnummer
				                                                ORDER BY BOD_Bodbedrag DESC) AND
																BOD_voorwerpnummer = VW_voorwerpnummer
						               ORDER BY BOD_Bodbedrag DESC) >= '$SearchMinPrice')
	AND ('$SearchMaxPrice' IS NULL OR (SELECT TOP 1 BOD_Bodbedrag
			                       FROM Bod
		                           WHERE BOD_Bodbedrag NOT IN (SELECT TOP 1 BOD_Bodbedrag
                                                           FROM Bod
                                                           WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                                           ORDER BY BOD_Bodbedrag DESC)
													 AND BOD_voorwerpnummer = VW_voorwerpnummer
									 ORDER BY BOD_Bodbedrag DESC) <= '$SearchMaxPrice')
	AND ('$SearchCategory' IS NULL OR r2.RB_Naam = '$SearchCategory')
	AND ('$SearchSubCategory' IS NULL OR r1.RB_Naam = '$SearchSubCategory')
	AND ('$SearchSubSubCategory' IS NULL OR Rubriek.RB_Naam = '$SearchSubSubCategory')
	AND ('$SearchPaymentMethod' IS NULL OR Voorwerp.VW_betalingswijze = '$SearchPaymentMethod')
	AND (VW_veilinggesloten != 1)
	GROUP BY  VW_voorwerpnummer,VW_titel,Rubriek.RB_Naam, VW_looptijdEinde, r1.RB_Naam, r2.RB_Naam, VW_betalingswijze
	ORDER BY VW_voorwerpnummer


EOT;

    print_r($QuerySearchProducts);



//executing the query


    return SendToDatabase($QuerySearchProducts);



}


?>

