<?php

/*change time formatting based on remaining time.
> 2 days = date
> 2 hours = hours + minutes
> 2 minutes minutes + seconds
< 2 minutes minutes + seconds
*/

/* Format date to Year-month-day Hour:minutes */
function ConvertTime($time)
{
    $datetime = new DateTime($time);
    return $datetime->format('Y-m-d H:i');
}


/* function for finding admin users and checking their credentials*/
function CheckCredentials($username, $password)
{
    $username = cleanInput($username);
    $password = cleanInput($password);

    GLOBAL $connection;
    GLOBAL $QueryCheckCredentials;

    $stmt = $connection->prepare($QueryCheckCredentials);
    $stmt->execute(array($username));
    $userInfo = $stmt->fetch();

    return password_verify($password, $userInfo["GEB_wachtwoord"]);
}

/* function for finding admin users */
function FindAdminUsers($username)
{
    GLOBAL $connection;
    GLOBAL $QueryFindAdmin;

    $username = cleanInput($username);

    $stmt = $connection->prepare($QueryFindAdmin);
    $stmt->execute(array($username));
    return $stmt->fetch();
}

/* function for Finding user info for profiel page*/
function findUserInfo($username)
{
  GLOBAL $connection;
  GLOBAL $QueryFindUserInfo;

  $stmt = $connection->prepare($QueryFindUserInfo);
  $stmt->execute(array($username));
  return $stmt-> fetchAll(); 

}


/*function for finding adverts per user*/
function findAuctionsByUser($username, $auction)
{
    GLOBAL $connection;
    GLOBAL $QueryFindAuctionsByUser;

    $stmt = $connection->prepare($QueryFindAuctionsByUser);
    $stmt->execute(array($username, $auction));
    return $stmt->fetchAll();


}

/* function for getting the results for the product page */

/* intake:
 * voorwerp id
 *
 *
 */


/* output:
 * the result from the database (array)
 * or an list with false, and the database error
 *
 */

function GetItemDetails($ItemID)
{

    $Query = <<<EOT

SELECT
  DISTINCT VW_voorwerpnummer,
  VW_titel,
  (COALESCE((SELECT TOP 1 BOD_Bodbedrag
             FROM Bod
             WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                     FROM Bod
                                     WHERE BOD_voorwerpnummer = $ItemID
                                     ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = $ItemID
             ORDER BY BOD_Bodbedrag DESC), (SELECT TOP 1 VW_startprijs
                                            FROM Voorwerp
                                            WHERE VW_voorwerpnummer = $ItemID))) AS prijs,
  Voorwerp.VW_looptijdEinde AS tijd,
  VR_Rubriek_Nummer,
  VW_thumbnail,
  CAST(VW_looptijdStart AS DATE) as VW_looptijdStart,
  VW_looptijdEinde,
  VW_betalingswijze,
  VW_beschrijving,
  VW_plaatsnaam,
  VW_land,
  VW_verkoper,
  VW_thumbnail,
  VW_veilinggesloten,
  VW_koper,
  VW_verkoopprijs,
  VW_verzendinstructies,
  VW_verzendkosten,
  VW_conditie, 
  VW_hoogstebod,
  VW_minimalenieuwebod
  
FROM Voorwerp
  FULL OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  LEFT OUTER JOIN Rubriek r1 ON r1.RB_Nummer = Rubriek.RB_Parent
  LEFT OUTER JOIN Rubriek r2 ON r2.RB_Nummer = r1.RB_Parent
  LEFT OUTER JOIN Rubriek r3 ON r3.RB_Nummer = r2.RB_Parent
  LEFT OUTER JOIN Rubriek r4 ON r4.RB_Nummer = r3.RB_Parent
WHERE VW_voorwerpnummer = $ItemID

EOT;
    Return SendToDatabase($Query);

}


/* function for getting the last offers of an auction */
function GetLastOffers($voorwerpnummer)
{

    $QueryGetLastOffers = <<<EOT
    
    select top 10 * from Bod where BOD_voorwerpnummer = $voorwerpnummer ORDER BY BOD_bodbedrag DESC

EOT;

    RETURN SendToDatabase($QueryGetLastOffers);
}

/* Function for the voowerperp page, helps build the breadcrums */
function GetAboveCategories($ItemID)
{
    GLOBAL $connection;
    $query = <<<EOT

with tab1(RB_Nummer,RB_Naam,RB_Parent,RB_volgnummer,RB_voorwerpcount) as
(select * from Rubriek where RB_Nummer = ?
 union all
select t1.* from Rubriek t1,tab1
where tab1.RB_Parent = t1.RB_Nummer AND tab1.RB_Parent != -1)
select top 5 RB_Naam, RB_Nummer from tab1;

EOT;

    $stmt = $connection->prepare($query);
    $stmt->execute(array((int)$ItemID));
    return $stmt->fetchAll();

}


function GetUserInfoPerAuction($username)
{

    $QueryGetUserInfo = <<<EOT
    
    SELECT GEB_rating 
    FROM Gebruiker
    WHERE GEB_gebruikersnaam = '$username'
  

EOT;

    //RETURN $QueryGetUserInfo;
    RETURN SendToDatabase($QueryGetUserInfo);
}

function GetCategoryPerAuction($categoryID)
{
    

    $QueryGetUserInfo = <<<EOT
    
    SELECT Name
FROM Categorieen
INNER JOIN Voorwerp_Rubriek
ON VR_Rubriek_Nummer = ID
WHERE VR_Voorwerp_Nummer = $categoryID
  

EOT;

    RETURN SendToDatabase($QueryGetUserInfo);
}


/* function for getting the images for an product */


/* input:
 * item id
 *
 *
 */


/* output:
 * array results from the database
 * or a list with false and a database error
 *
 *
 */

function GetItemImages($ItemID)
{

    $Query = <<< EOT

SELECT DISTINCT BES_filenaam
FROM Bestand, Voorwerp
WHERE Bestand.BES_voorwerpnummer = $ItemID

EOT;
    return SendToDatabase($Query);
}


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


// Insert data in de DB
function InsertIntoDatabase($SetRegistratie, $email, $code)
{
    GLOBAL $connection;
    $stmt = $connection->prepare($SetRegistratie);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':code', $code);
    $stmt->execute();
}

/*this function inserts an offer into the database */

/*
 * intake:
 * the $bod (offer)
 * the user
 * itemID
 */


/*
 * output:
 * nothing
 *
 */

function insertBod($itemID, $user, $offer)
{
    GLOBAL $connection;

    $query = <<<EOT

INSERT INTO Bod (BOD_voorwerpnummer, BOD_gebruiker, BOD_bodbedrag)
VALUES (:itemID , :user, :offer )

EOT;

    $stmt = $connection->prepare($query);
    $stmt->bindParam(':offer', $offer);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':itemID', $itemID);
    $stmt->execute();

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
    $pagina = 'Voorpagina';
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-xs-12 col-sm-6 col-md-4 col-lg-3\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" . $auction["VW_titel"] . "
                    </div>
                    <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \"><div class=\"veiling-image\" style=\"background-image:url(" . 'http://iproject3.icasites.nl/thumbnails/' . $auction["ImagePath"] . ")\"></div></a>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . "<p id=" . $auction["VW_voorwerpnummer"] . "></p>" . "</div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \" class=\"btn text-center btn-default bied\">Meer info</a>
                        <a href= \"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] .'&snelbod=True'. "\"  class=\"btn text-center btn-info bied\">Bied Nu!</a>
                    </div>
                </div>
            </div>
            <!-- End template -->
            
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"], $auction["VW_voorwerpnummer"]);

}
function DrawItemAuction($auction)
{
    //testing for missing images and replacing with backup image
    if (empty($auction["ImagePath"])) {
        $auction["ImagePath"] = "images/no-image-available.jpg";
    }
    $pagina = 'Voorpagina';
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-xs-12\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" . $auction["VW_titel"] . "
                    </div>
                    <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \"><div class=\"veiling-image\" style=\"background-image:url(" . 'http://iproject3.icasites.nl/thumbnails/' . $auction["ImagePath"] . ")\"></div></a>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . "<p id=" . $auction["VW_voorwerpnummer"] . "></p>" . "</div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \" class=\"btn text-center btn-default bied\">Meer info</a>
                        <a href= \"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] .'&snelbod=True'. "\"  class=\"btn text-center btn-info bied\">Bied Nu!</a>
                    </div>
                </div>
            </div>
            <!-- End template -->
            
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"], $auction["VW_voorwerpnummer"]);

}

function DrawSearchResults($auction)
{
    //testing for missing images and replacing with backup image
    if (empty($auction["ImagePath"])) {
        $auction["ImagePath"] = "images/no-image-available.jpg";
    }
    $pagina = 'Zoekpagina';
    echo "
    <!-- Veiling template -->
            <div class=\"veiling-rand col-md-4 col-sm-6 col-xs-12\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" .
        $auction["VW_titel"] . "
                    </div>"
        . "<a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \">" . "<div class=\"veiling-image\" style=\"background-image:url(" . 'http://iproject3.icasites.nl/thumbnails/' . $auction["ImagePath"] . ")\"></div></a>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . "<p id=" . $auction["VW_voorwerpnummer"] . "></p>" . " </div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \" class=\"btn text-center btn-default bied\">Meer info</a>
                        <a href= \"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] .'&snelbod=True'. "\"  class=\"btn text-center btn-info bied\">Bied Nu!</a>
                    </div>
                </div>
            </div>
            <!-- End template -->
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"], $auction["VW_voorwerpnummer"]);

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
    $SearchKeyword = $SearchOptions['SearchKeyword'];
    $SearchPaymentMethod = $SearchOptions['SearchPaymentMethod'];
    $SearchFilter = $SearchOptions['SearchFilter'];
    $SearchCategory = $SearchOptions['SearchCategory'];
    $SearchMaxRemainingTime = $SearchOptions['SearchMaxRemainingTime'];
    $SearchMinRemainingTime = $SearchOptions['SearchMinRemainingTime'];
    $SearchMinPrice = $SearchOptions['SearchMinPrice'];
    $SearchMaxPrice = $SearchOptions['SearchMaxPrice'];
    $SearchUser = $SearchOptions['SearchUser'];
    $ResultsPerPage = $SearchOptions['ResultsPerPage'];
    $Offset = $SearchOptions['Offset'];

    //clean the input
    $SearchKeyword = cleanInput($SearchKeyword);
    $SearchPaymentMethod = cleanInput($SearchPaymentMethod);
    $SearchFilter = cleanInput($SearchFilter);
    $SearchCategory = cleanInput($SearchCategory);
    $SearchMaxRemainingTime = cleanInput($SearchMaxRemainingTime);
    $SearchMinRemainingTime = cleanInput($SearchMinRemainingTime);
    $SearchMinPrice = cleanInput($SearchMinPrice);
    $SearchMaxPrice = cleanInput($SearchMaxPrice);
    $ResultsPerPage = cleanInput($ResultsPerPage);
    $SearchUser = cleanInput($SearchUser);
    $Offset = cleanInput($Offset);

//Prepare the query
    $QuerySearchProducts = <<< EOT
SELECT DISTINCT
  VW_minimalenieuwebod,
  VW_voorwerpnummer,
  VW_titel,
  (COALESCE((SELECT TOP 1 BOD_Bodbedrag
             FROM Bod
             WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                                     FROM Bod
                                     WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                                     ORDER BY BOD_Bodbedrag DESC) AND
                   BOD_voorwerpnummer = VW_voorwerpnummer
             ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) AS prijs,
  DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) AS tijd,
  VW_thumbnail       AS ImagePath,
  VW_looptijdStart,
  VW_looptijdEinde,
  VW_betalingswijze,
  VW_verkoper,
  count(BOD_voorwerpnummer) as aantalBiedingen,
  GEB_rating
FROM Voorwerp
  LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Gebruiker on Gebruiker.GEB_gebruikersnaam = Voorwerp.VW_verkoper
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  LEFT OUTER JOIN Rubriek r1 ON r1.RB_Nummer = Rubriek.RB_Parent
  LEFT OUTER JOIN Rubriek r2 ON r2.RB_Nummer = r1.RB_Parent
  LEFT OUTER JOIN Rubriek r3 ON r3.RB_Nummer = r2.RB_Parent
  LEFT OUTER JOIN Rubriek r4 ON r4.RB_Nummer = r3.RB_Parent
WHERE (VW_titel LIKE '%$SearchKeyword%')
  AND ($SearchMaxRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) <= $SearchMaxRemainingTime)
  AND ($SearchMinRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) >= $SearchMinRemainingTime)
  AND ($SearchMinPrice IS NULL OR (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) >= $SearchMinPrice)
  AND ($SearchMaxPrice IS NULL OR (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) <= $SearchMaxPrice)
    AND ($SearchCategory IS NULL OR Rubriek.RB_Nummer = $SearchCategory OR r1.RB_Nummer = $SearchCategory OR r2.RB_Nummer = $SearchCategory OR r3.RB_Nummer = $SearchCategory OR r4.RB_Nummer = $SearchCategory)
    AND (NULL IS NULL OR Voorwerp.VW_betalingswijze like '%%')
    AND(VW_verkoper LIKE '%$SearchUser%')
  AND (VW_veilinggesloten != 1)
GROUP BY VW_voorwerpnummer, VW_titel, Rubriek.RB_Naam, VW_looptijdEinde, r1.RB_Naam, r2.RB_Naam, VW_betalingswijze,Voorwerp.VW_looptijdStart,
   Voorwerp.VW_looptijdEinde,VW_looptijdStart, VW_looptijdEinde, VW_startprijs, VW_thumbnail,VW_verkoper,GEB_rating, VW_minimalenieuwebod
ORDER BY $SearchFilter , VW_voorwerpnummer
OFFSET $Offset ROWS
FETCH NEXT $ResultsPerPage ROWS ONLY


    
EOT;
    //executing the query
    return SendToDatabase($QuerySearchProducts);


}

//This function returns the amount of results left in the next 4 pages.
//The query counts the results starting at the next page and ending at the fifth page after the current one
function amountOfResultsLeft($SearchOptions)
{
    //preparing for query
    $SearchKeyword = $SearchOptions['SearchKeyword'];
    $SearchPaymentMethod = $SearchOptions['SearchPaymentMethod'];
    $SearchCategory = $SearchOptions['SearchCategory'];
    $SearchMaxRemainingTime = $SearchOptions['SearchMaxRemainingTime'];
    $SearchMinRemainingTime = $SearchOptions['SearchMinRemainingTime'];
    $SearchMinPrice = $SearchOptions['SearchMinPrice'];
    $SearchMaxPrice = $SearchOptions['SearchMaxPrice'];
    $SearchUser = $SearchOptions['SearchUser'];
    $ResultsPerPage = $SearchOptions['ResultsPerPage'];
    $Offset = $SearchOptions['Offset'];
    //clean the input
    $SearchKeyword = cleanInput($SearchKeyword);
    $SearchPaymentMethod = cleanInput($SearchPaymentMethod);
    $SearchCategory = cleanInput($SearchCategory);
    $SearchMaxRemainingTime = cleanInput($SearchMaxRemainingTime);
    $SearchMinRemainingTime = cleanInput($SearchMinRemainingTime);
    $SearchMinPrice = cleanInput($SearchMinPrice);
    $SearchMaxPrice = cleanInput($SearchMaxPrice);
    $ResultsPerPage = cleanInput($ResultsPerPage);
    $SearchUser = cleanInput($SearchUser);
    $Offset = cleanInput($Offset);

//Prepare the query
    $QuerySearchProducts = <<< EOT
    
select COUNT(getal) as totaal
FROM (
SELECT DISTINCT
  VW_voorwerpnummer,
  count(VW_voorwerpnummer) as getal
FROM Voorwerp
  LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  LEFT OUTER JOIN Rubriek r1 ON r1.RB_Nummer = Rubriek.RB_Parent
  LEFT OUTER JOIN Rubriek r2 ON r2.RB_Nummer = r1.RB_Parent
  LEFT OUTER JOIN Rubriek r3 ON r3.RB_Nummer = r2.RB_Parent
  LEFT OUTER JOIN Rubriek r4 ON r4.RB_Nummer = r3.RB_Parent
WHERE ('$SearchKeyword' IS NULL OR VW_titel LIKE '%$SearchKeyword%')
  AND ($SearchMaxRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) <= $SearchMaxRemainingTime)
  AND ($SearchMinRemainingTime IS NULL OR DATEDIFF(HOUR, GETDATE(), Voorwerp.VW_looptijdEinde) >= $SearchMinRemainingTime)
  AND ($SearchMinPrice IS NULL OR (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) >= $SearchMinPrice)
  AND ($SearchMaxPrice IS NULL OR (COALESCE ((SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag  IN (SELECT TOP 1 BOD_Bodbedrag
                               FROM Bod
                               WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                               ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC), VW_startprijs)) <= $SearchMaxPrice)
    AND ($SearchCategory IS NULL OR Rubriek.RB_Nummer = $SearchCategory OR r1.RB_Nummer = $SearchCategory OR r2.RB_Nummer = $SearchCategory OR r3.RB_Nummer = $SearchCategory OR r4.RB_Nummer = $SearchCategory)
    AND (NULL IS NULL OR Voorwerp.VW_betalingswijze like '%%')
        AND('$SearchUser' IS NULL OR VW_verkoper LIKE '%$SearchUser%')
  AND (VW_veilinggesloten != 1)
GROUP BY VW_voorwerpnummer
ORDER BY  VW_voorwerpnummer
OFFSET $Offset+$ResultsPerPage ROWS
FETCH NEXT $ResultsPerPage*4 ROWS ONLY
) as test

    
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

function printBetalingswijzen($Betaalmethodes){
    foreach($Betaalmethodes as $betaalmethode){
        echo '<option value="' . $betaalmethode['BW_betalingswijze'] . '">'. $betaalmethode['BW_betalingswijze'] .'</option>';
    }
}

//Returns the Numbers of all parent Categories from the categorie you enter
function getParentCategories($rubriekNummer)
{
    GLOBAL $connection;
    $QueryParentCategories = <<<EOT
    
with tab1(RB_Nummer,RB_Naam,RB_Parent,RB_volgnummer,RB_voorwerpcount) as
(select * from Rubriek where RB_Nummer = $rubriekNummer
union all
select t1.* from Rubriek t1,tab1 
where tab1.RB_Parent = t1.RB_Nummer)
select RB_Nummer from tab1;


EOT;
    RETURN $connection->query($QueryParentCategories)->fetchAll(PDO::FETCH_COLUMN);
}

//Prints all categories in the Rubriek table in the right orer.
function printCategories($zoekterm, $rubriekQuery, $rubriekNummer, $sorteerfilter, $prijs, $betalingsmethode)
{
    global $connection;
    //When a rubriekNummer is entered the function getParentCategories returns all Numbers of the parents
    //These are used to open the selected categories
    if (!empty($rubriekNummer)) {
        $parentRubrieken = getParentCategories($rubriekNummer);
    }
    //Returns all Categories in the following format: Head-categorie/categorie/subcategorie/subsubcategorie and so on
    $rubrieken = $connection->query($rubriekQuery)->fetchAll(PDO::FETCH_NUM);
    //Unorderlist with all Categories in it. The class is used to be able to open and close the unorder list.
    echo '<ul id="Rubrieken" class="nav panel-collapse collapse in">';
    //Goes through the first dimensional of the array
    for ($i = 0; $i < sizeof($rubrieken); $i++) {
        //Goes through the second dimensional of the array
        for ($j = 0; $j < (sizeof($rubrieken[$i]) / 2); $j++) {
            //If the next value is not set OR the value is the last value a line is printed this line is the last line in the tree
            if (!isset($rubrieken[$i][$j + 1]) OR ($j == (sizeof($rubrieken[$i]) / 2) - 1) AND isset($rubrieken[$i][$j])) {
                //If a rubriekNummer was entered and the current categorie number is in the array $parentRubrieken it will have a primrose yellow background
                if (in_array($rubrieken[$i][$j + 6], $parentRubrieken)) {
                    echo "<div class=\"label-info\"><a href=?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubrieken[$i][$j + 6]) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . '1' . ">" . $rubrieken[$i][$j] . "</a></div><ul>";
                } else {
                    echo "<a href=?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubrieken[$i][$j + 6]) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=" . '1' . ">" . $rubrieken[$i][$j] . "</a><ul>";
                }
                //If the last object in the three was printed it will stop the second loop.
                $j = sizeof($rubrieken[$i]);
            } //If the current category is set and it is not the same as the category from last row a new Unordered list will be created
            else if ($i <= 0 OR $rubrieken[$i][$j] != $rubrieken[$i - 1][$j] AND isset($rubrieken[$i][$j])) {
                //If  a rubriekNummer was entered and the current categorie number is in the array $parentRubrieken it will be opened and it will have a primrose yellow background
                if (in_array($rubrieken[$i][$j + 6], $parentRubrieken)) {
                    echo '<li><div class="label-info tree-toggle nav-header">' . $rubrieken[$i][$j] . '</div><ul class="nav nav-list tree">';
                } else {
                    echo '<li><label class="tree-toggle nav-header">' . $rubrieken[$i][$j] . '</label>
                        <ul class="nav nav-list tree" style="display: none">';
                }
            }
        }
        //For loop to close the list items and unorderd lists it closes "backwards"
        for ($k = (sizeof($rubrieken[$i]) / 2) - 1; $k >= 0; $k--) {
            //If the last rubric is set and the Last Rubric is not the same as the next Rubric
            if ($i + 1 >= sizeof($rubrieken)) {
                echo '</ul></li>';
            } else if ($rubrieken[$i][$k] != $rubrieken[$i + 1][$k] AND isset($rubrieken[$i][$k])) {
                echo '</ul></li>';
            }
        }
        echo '<hr size="6">';
    }
    echo '</ul>';
}
function printCategoriesAdvertentiePagina($rubriekQuery, $rubriekNummer)
{
    global $connection;
    //When a rubriekNummer is entered the function getParentCategories returns all Numbers of the parents
    //These are used to open the selected categories
    if (!empty($rubriekNummer)) {
        $parentRubrieken = getParentCategories($rubriekNummer);
    }
    //Returns all Categories in the following format: Head-categorie/categorie/subcategorie/subsubcategorie and so on
    $rubrieken = $connection->query($rubriekQuery)->fetchAll(PDO::FETCH_NUM);
    //Unorderlist with all Categories in it. The class is used to be able to open and close the unorder list.
    echo '<ul id="Rubrieken" class="nav panel-collapse collapse in">';
    //Goes through the first dimensional of the array
    for ($i = 0; $i < sizeof($rubrieken); $i++) {
        //Goes through the second dimensional of the array
        for ($j = 0; $j < (sizeof($rubrieken[$i]) / 2); $j++) {
            //If the next value is not set OR the value is the last value a line is printed this line is the last line in the tree
            if (!isset($rubrieken[$i][$j + 1]) OR ($j == (sizeof($rubrieken[$i]) / 2) - 1) AND isset($rubrieken[$i][$j])) {
                //If a rubriekNummer was entered and the current categorie number is in the array $parentRubrieken it will have a primrose yellow background
                if (in_array($rubrieken[$i][$j + 6], $parentRubrieken)) {
                    echo "<div class='label-info'><a href=?rubriek=" . urldecode($rubrieken[$i][$j + 6]) . ">" . urldecode($rubrieken[$i][$j]). "</a></div><ul>";
                } else {
                    echo "<a href=?rubriek=" . urldecode($rubrieken[$i][$j + 6]) . ">" . urldecode($rubrieken[$i][$j]). "</a><ul>";                }
                //If the last object in the three was printed it will stop the second loop.
                $j = sizeof($rubrieken[$i]);
            } //If the current category is set and it is not the same as the category from last row a new Unordered list will be created
            else if ($i <= 0 OR $rubrieken[$i][$j] != $rubrieken[$i - 1][$j] AND isset($rubrieken[$i][$j])) {
                //If  a rubriekNummer was entered and the current categorie number is in the array $parentRubrieken it will be opened and it will have a primrose yellow background
                if (in_array($rubrieken[$i][$j + 6], $parentRubrieken)) {
                    echo '<li><div class="label-info tree-toggle nav-header">' . $rubrieken[$i][$j] . '</div><ul class="nav nav-list tree">';
                } else {
                    echo '<li><label class="tree-toggle nav-header">' . $rubrieken[$i][$j] . '</label>
                        <ul class="nav nav-list tree" style="display: none">';
                }
            }
        }
        //For loop to close the list items and unorderd lists it closes "backwards"
        for ($k = (sizeof($rubrieken[$i]) / 2) - 1; $k >= 0; $k--) {
            //If the last rubric is set and the Last Rubric is not the same as the next Rubric
            if ($i + 1 >= sizeof($rubrieken)) {
                echo '</ul></li>';
            } else if ($rubrieken[$i][$k] != $rubrieken[$i + 1][$k] AND isset($rubrieken[$i][$k])) {
                echo '</ul></li>';
            }
        }
        echo '<hr size="6">';
    }
    echo '</ul>';
}

function drawPagenumbers($pagenum,$Dictionary,$result,$ResultsPerPage,$zoekterm,$rubriek,$sorteerfilter,$prijs,$betalingsmethode,$user){
    if (!empty($result)) {
        //Returns the amount of results on the next 4 pages.
        $amountOfResults = amountOfResultsLeft($Dictionary);
        //Calculate the amount of pages by deviding the count with the amount of results per page.
        $amountOfFuturePages = ceil($amountOfResults[0]['totaal'] / $ResultsPerPage);
        $previousPage = $pagenum - 1;
        $lastPageNum = $pagenum + $amountOfFuturePages;
        $startPage = $pagenum - 4 + $amountOfFuturePages;

        //Prevent startPage to be <=0

        $nextPage = $pagenum + 1;
        // If the current page is not the first one. The first pagenumber created has to be the one before the current page.
        if ($pagenum != 1) {
            $startPage--;
            echo '<li class="page-item">';
            echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . urlencode($betalingsmethode) . "&user=" . $user . "&pagenum=" . $previousPage . "> <- Vorige</a> ";
            echo '</li>';
        }
        if ($startPage < 1) {
            $startPage = 1;
        }
        if($lastPageNum >= $pagenum + 4){
            $lastPageNum --;
        }
        //Loop creates all buttons to the next or pages before the current one.
        for ($i = $startPage; $i <= $lastPageNum; $i++) {
            if ($i == $pagenum) {
                echo '<li class="page-item active text-center">';
                echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . urlencode($betalingsmethode) . "&user=" . $user . "&pagenum=" . $i . ">" . $i . "</a> ";
                echo '</li>';
            } else {
                echo '<li class="page-item">';
                echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . urlencode($betalingsmethode) . "&user=" . $user . "&pagenum=" . $i . ">" . $i . "</a> ";
                echo '</li>';
            }
        }
        //Only when the amount of future pages is 1 or higher the next button will be created. This since there is no next page when there are no future pages.
        if ($amountOfFuturePages > 0) {
            echo '<li class="page-item">';
            echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&rubriek=" . urldecode($rubriek) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . urlencode($betalingsmethode) . "&user=" . $user . "&pagenum=" . $nextPage . ">Volgende -></a> ";
            echo '</li></ul>';
        }
    }
    //If the page does not exist since there aren't enough results an error message will be shown. If the current page is one there won't be shown an error message
    //this since there are no results at all and not that there aren't enough results.
    elseif ($pagenum != 1) {
        echo '<h1> Page ' . $pagenum . ' does not exist</h1>';
    }
                echo '</div>';


//Einde Paginanummering
}

function createTimer($tijd, $VW_Titel, $VW_Nummer)
{
    echo '<script>
    // Set the date we\'re counting down to
    var countDownDate = new Date("' . $tijd . '").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        
        if(days >= 1){
        document.getElementById("' . $VW_Nummer . '").innerHTML = days + "d " + hours + "h "
            + minutes + "m " ;
        }else if(days < 1 && seconds < 10){
        document.getElementById("' . $VW_Nummer . '").innerHTML = hours + "h "
            + minutes + "m " + "0" + seconds + "s" ;
        }else{
        document.getElementById("' . $VW_Nummer . '").innerHTML = hours + "h "
            + minutes + "m " + seconds +  "s" ;
        }
        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("' . $VW_Nummer . '").innerHTML = "Veiling gesloten";
        }
    }, 1000)
</script>
';
}


// functie die email adres invult bij laden registreer1.php indien al ingevuld.
function getEmailReg1()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email'])) {
            $email = cleanInput($_POST['email']);
            echo $email;
        }
    }
}


// Indien gebruiker email heeft ingevuld en op verstuur heeft geklikt, wordt er een check uitgevoerd.
// Vervolgens wordt er een email verstuurd en een message weergegeven.
function checkEmailSent()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ((isset($_POST['email'])) && (!empty($_POST['email'])) && (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == true)) {
            $email = cleanInput($_POST['email']);
            $code = md5($email . date("Y/m/d"));
            $code = substr($code, 0, 16);
            $urlCode = urlencode($code);
            global $SetRegistratie;

            // Mail Headers
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: info@iproject3.icasites.nl' . "\r\n";
            $subject = 'Uw EenmaalAndermaal registratie';
            //Verificatie mail 
            $message = '
<!DOCTYPE html><html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width">
    
    <title>Email Verificatie</title>
    <style type="text/css">
            /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 620px) {
              table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important; }
              table[class=body] p,
              table[class=body] ul,
              table[class=body] ol,
              table[class=body] td,
              table[class=body] span,
              table[class=body] a {
                font-size: 16px !important; }
              table[class=body] .wrapper,
              table[class=body] .article {
                padding: 10px !important; }
              table[class=body] .content {
                padding: 0 !important; }
              table[class=body] .container {
                padding: 0 !important;
                width: 100% !important; }
              table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important; }
              table[class=body] .btn table {
                width: 100% !important; }
              table[class=body] .btn a {
                width: 100% !important; }
              table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important; }}
            /* -------------------------------------
              HEAD STYLES
            ------------------------------------- */
            @media all {
              .ExternalClass {
                width: 100%; }
              .ExternalClass,
              .ExternalClass p,
              .ExternalClass span,
              .ExternalClass font,
              .ExternalClass td,
              .ExternalClass div {
                line-height: 100%; }
              .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important; }
              .btn-primary table td:hover {
                background-color: #35316f !important; }
              .btn-primary a:hover {
                background-color: #35316f !important;
                border-color: #35316f !important; } }
    </style>
  </head>
  <body class="" style="background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background-color:#f6f6f6;width:100%;">
      <tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
        <td class="container" style="font-family:sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;padding:10px;width:580px;Margin:0 auto !important;">
          <div class="content" style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
              <!-- START MAIN CONTENT AREA -->
              <div style="background-color: #f6d155">
                <tr>
                </tr>
                <tr>
                  <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color: #f6d155;">
                    <a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;">
                      <img src="http://iproject3.icasites.nl/images/testlogo.png" alt="EenmaalAndermaal Logo" height="70" width="auto" style="border:none;-ms-interpolation-mode:bicubic;max-width:100%;margin:15px;">
                    </a>
                  </td>
                </tr>
              </div>
              <td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                  <tr>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Beste gebruiker,</p>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">U heeft aangegeven zich aan te willen melden op EenmaalAndermaal. Dit is uw persoonlijke code: <b> ' . $code . ' </b> </p>
                  </tr>
                </table>
                <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Vul deze in op de website om de registratieprocedure af te ronden of klik op de activeer knop.</p>
                <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;box-sizing:border-box;width:100%;">
                  <tbody>
                    
                      <td align="left" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;width:auto;">
                          <tbody>
                           
                              <td style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color:#ffffff;border-radius:5px;text-align:center;background-color:#413b88;"> <a href="http://iproject3.icasites.nl/registreer1.php?code=' . $code . ' " target="_blank" style="text-decoration:underline;background-color:#ffffff;border:solid 1px #413b88;border-radius:5px;box-sizing:border-box;color:#413b88;cursor:pointer;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#413b88;border-color:#413b88;color:#ffffff;">activeren</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Met vriendelijke groet,</p>
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Het EenmaalAndermaal Team</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- START FOOTER -->
            <div class="footer" style="clear:both;padding-top:10px;text-align:center;width:100%;background-color: #444;">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                <tr>
                  <td class="content-block" style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center; margin-bottom:10px color: #f0f0f0;">
                    <span class="apple-link" style="color:#fff;font-size:12px;text-align:center;"><a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;color:#fff;font-size:12px;text-align:center;"><u>EenmaalAndermaal B.V.</u></a></span>
                    <br>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;color:#fff;font-size:12px;text-align:center;">KVK-nummer: 09091785</p>
                  </td>
                </tr>
                <tr>
                  <td style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center;">
                    Powered by Groep 3
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
';


// If already in DB
            $sql = " select * from (select GEB_mailbox as email from Gebruiker union all select REG_email from Registreer) a where email = '$email'";
            $getUser = SendToDatabase($sql);

            if ($getUser) { //IF waarde (dus niet leeg)
                // Display error
                echo '  <div class="alert alert-danger" >
                        <strong > Fout!</br></strong > Er is al een verificatie verstuurd naar ' . $email . ' of er bestaat al een account met dit E-mailadres.
                        </div > ';
            } else { // indien WEL leeg is er dus geen bestaande user met dit e-mailadres gevonden, en kan de gebruiker worden geregistreerd.
                // Send to DB
                InsertIntoDatabase($SetRegistratie, $email, $code);
                mail($email, $subject, $message, $headers);
                echo '  <div class="alert alert-success">
                            <strong>Success!</strong>Er is een verificatiecode verzonden naar ' . $email . '!</div>';
            }
        } else if(!isset($_POST['code'])) {
            echo '  <div class="alert alert-danger" >
                        <strong > Fout!</br></strong > Vul A.U.B. een geldig E-mailadres in.
                        </div > ';
        }
    }
}

// Controlleert of de ingevoerde validatiecode op registreerq.php correct is. Indien ja > doorverwijzing naar registreer2.php, zo niet dan error.
function checkUserLinked()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['code'])) {
            $code = cleanInput($_POST['code']);
            $sql = "SELECT * FROM Registreer WHERE REG_code = '$code'";
            $getUser = SendToDatabase($sql);

            if (!$getUser) {
                echo '  <div class="alert alert-danger" >
                                    <strong > Fout!</strong > Er is geen gebruiker gekoppeld aan deze code </div > ';
            } else {
                $_SESSION["emailadres"] = cleanInput($getUser[0]['REG_email']);
                header('Location: registreer2.php');
            }

        }
    }
}

function validateHash()
{
    if (isset($_SESSION['emailadres']) && !empty($_SESSION['emailadres'])) {
        $emailadres = cleanInput($_SESSION["emailadres"]);
        session_unset();
    } else {
        header('Location: registreer1.php');
        session_destroy();
    }
    return $emailadres;
}


function checkRegistratie()
{


    global $waardes;
    global $emailadres; // Komt uit functie validateHash. Haalt email op indien gebruiker van pagina registreer1 af komt en vult deze dan in.

    $error = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (count($_POST) == 14) {
            foreach ($_POST as $veld => $value) {
                if (empty($value)) {
                    If ($veld != 'adres2') {
                        $error = true;
                        echo '  <div class="alert alert-danger" >
                            <strong >Fout!</br></strong >' . $veld . ' niet ingevuld. </div > ';
                    }
                }
            }

            $waardes = $_POST;
            foreach ($waardes as $waarde) {
                $waarde = cleanInput($waarde);
            }


            if ($error == false) {

                $waardes['antwoord'] = strtolower($waardes['antwoord']); // Lower case maken

                $today_start = strtotime('today');
                $date_timestamp = strtotime($waardes['geboortedatum']);

                $gebruikersnaam = $waardes['gebruikersnaam']; // Kan $waardes['gebruikersnaam'] niet IN de Querie gebruiken.
                $sql = "SELECT * FROM Gebruiker WHERE GEB_gebruikersnaam LIKE '$gebruikersnaam'";
                $getUser = SendToDatabase($sql);

                if ($getUser) {
                    echo '  <div class="alert alert-danger" >
                                    <strong > Fout!</strong > Er is al een gebruiker met deze gebruikersnaam! </div > ';

                } else if ($date_timestamp > $today_start) {
                    echo '  <div class="alert alert-danger" >
                            <strong >Fout!</br></strong > Uw geboortedatum moet in het verleden liggen! </div > ';

                } else if (strlen($waardes['wachtwoord']) < 8) {
                    echo '  <div class="alert alert-danger" >
                            <strong >Fout!</br></strong > Het opgegeven wachtwoord moet minimaal 8 tekens lang zijn! </div > ';

                } else if ($waardes['wachtwoord'] == ($waardes['wachtwoord2'])) {

                    $waardes['wachtwoord'] = password_hash($waardes['wachtwoord'], PASSWORD_DEFAULT);
                    $waardes['antwoord'] = password_hash($waardes['antwoord'], PASSWORD_DEFAULT);
                    $_SESSION = $waardes;
                    header('Location: voltooi-registratie.php');
                } else {
                    echo '  <div class="alert alert-danger" >
                            <strong >Fout!</br></strong > De ingevoerde wachtwoorden zijn niet identiek! </div > ';
                }
            } else {
                echo '  <div class="alert alert-danger" >
                            <strong >Fout!</br></strong > Niet alle velden zijn ingevuld! </div > ';
            }
        }
    } else {
        $emailadres = validateHash();
    }
}


function doRegistratie()
{
    $error = false; // Dibran stelde voor dit op een andere plek neer te zetten, But I'm a Rebbbbeelllllll

    if (count($_SESSION) == 14) {
        foreach ($_SESSION as $veld => $value) {
            $veld = cleanInput($veld);
        }


        if ($error == false) {


            // Insert new user into Gebruiker Table
            $sqlInsertUser = <<<EOT
        INSERT INTO Gebruiker ( GEB_gebruikersnaam,  GEB_voornaam,   GEB_achternaam,   GEB_adresregel_1, GEB_adresregel_2,   GEB_postcode,   GEB_plaatsnaam,   GEB_Land,   GEB_geboortedag,    GEB_mailbox,  GEB_wachtwoord,   GEB_vraag,      GEB_antwoordtekst,  GEB_verkoper)
        VALUES        ( :gebruikersnaam,     :voornaam,      :achternaam,      :adres1,          :adres2,            :postcode,      :woonplaats,      :land   ,   :geboortedatum ,    :email,       :wachtwoord,      :geheimevraag,  :antwoord,          '0')
EOT;

            GLOBAL $connection;
            $stmt = $connection->prepare($sqlInsertUser);
            $stmt->bindParam(':gebruikersnaam', $_SESSION['gebruikersnaam']);
            $stmt->bindParam(':voornaam', $_SESSION['voornaam']);
            $stmt->bindParam(':achternaam', $_SESSION['achternaam']);
            $stmt->bindParam(':adres1', $_SESSION['adres1']);
            $stmt->bindParam(':adres2', $_SESSION['adres2']);
            $stmt->bindParam(':postcode', $_SESSION['postcode']);
            $stmt->bindParam(':woonplaats', $_SESSION['woonplaats']);
            $stmt->bindParam(':land', $_SESSION['land']);
            $stmt->bindParam(':geboortedatum', $_SESSION['geboortedatum']);
            $stmt->bindParam(':email', $_SESSION['email']);
            $stmt->bindParam(':wachtwoord', $_SESSION['wachtwoord']);
            $stmt->bindParam(':geheimevraag', $_SESSION['geheimevraag']);
            $stmt->bindParam(':antwoord', $_SESSION['antwoord']);
            $stmt->execute();

            // Delete user from Registratie Table
            $sqlDeleteUser = <<<EOT
        DELETE FROM Registreer WHERE REG_email = :email
EOT;

            GLOBAL $connection;
            $stmt = $connection->prepare($sqlDeleteUser);
            $stmt->bindParam(':email', $_SESSION['email']);
            $stmt->execute();
            $geregistreerdeGebruiker = $_SESSION['gebruikersnaam'];
            session_unset();

            $_SESSION["Username"] = $geregistreerdeGebruiker;
            echo '  <div class="alert alert-success">
                            <strong>Success!</strong>U bent succesvol geregistreerd op EenmaalAndermaal!</div>
                            <hr>
            <p class="text-center">U bent tevens ingelogd.</p>
            ';

        }
    } else {
        session_destroy();
        header('Location: registreer1.php');
    }

}

function getCodeFromMail()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        IF (!empty($_GET['code'])) {
            echo $_GET['code'];
        }
    }
}

function FindUser($username)
{
    GLOBAL $connection;
    GLOBAL $QueryFindUser;

    $username = cleanInput($username);

    $stmt = $connection->prepare($QueryFindUser);
    $stmt->execute(array($username));
    return $stmt->fetch();
}

?>