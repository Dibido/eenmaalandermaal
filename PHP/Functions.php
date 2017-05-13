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



function SendToDatabase($query) {
    GLOBAL $connection;

    //tries to send the query and returns the response
    try {
        return $response = $connection->query($query)->fetchAll(PDO::FETCH_ASSOC);

    //if unsuccessful, returns a False as first item and the error as the second item in a list
    } catch (Exception $e) {
        return [False, 'Error: ' .  $e->getMessage()];
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


function DrawAuction($auction){
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-2\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-info\">
                        Gratis Model S
                    </div>
                    <div class=\"veiling-image\" style=\"background-image:url(images/16-9.jpeg)\"></div>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> 150000</div>
                        <div class=\"tijd label label-default\">1:15:25 <i class=\"glyphicon glyphicon-time\"></i></div>
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



?>

