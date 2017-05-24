<?php
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
  (SELECT TOP 1 BOD_Bodbedrag
   FROM Bod
   WHERE BOD_Bodbedrag IN (SELECT TOP 1 BOD_Bodbedrag
                           FROM Bod
                           WHERE BOD_voorwerpnummer = VW_voorwerpnummer
                           ORDER BY BOD_Bodbedrag DESC) AND BOD_voorwerpnummer = VW_voorwerpnummer
   ORDER BY BOD_Bodbedrag DESC)                        AS prijs,
  Voorwerp.VW_looptijdEinde AS tijd,
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
  VW_conditie
FROM Voorwerp
  LEFT OUTER JOIN Bod ON Bod.BOD_voorwerpnummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Voorwerp_Rubriek ON Voorwerp_Rubriek.VR_Voorwerp_Nummer = Voorwerp.VW_voorwerpnummer
  LEFT OUTER JOIN Rubriek ON Rubriek.RB_Nummer = Voorwerp_Rubriek.VR_Rubriek_Nummer
  LEFT OUTER JOIN Rubriek r1 ON r1.RB_Nummer = Rubriek.RB_Parent
  LEFT OUTER JOIN Rubriek r2 ON r2.RB_Nummer = r1.RB_Parent
  LEFT OUTER JOIN Rubriek r3 ON r3.RB_Nummer = r2.RB_Parent
  LEFT OUTER JOIN Rubriek r4 ON r4.RB_Nummer = r3.RB_Parent
WHERE VW_voorwerpnummer = $ItemID

SELECT * FROM Voorwerp

EOT;

    Return SendToDatabase($Query);

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
                    <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \"><div class=\"veiling-image\" style=\"background-image:url(" . $auction["ImagePath"] . ")\"></div></a>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . '<p id="timer' . $auction["VW_titel"] . $pagina . '"></p>' . "</div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \" class=\"btn text-center btn-default bied\">Meer info</a>
                        <a class=\"btn text-center btn-info bied\">Bied Nu!</a>
                    </div>
                </div>
            </div>
            <!-- End template -->
            
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"], $pagina);

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
            <div class=\"veiling-rand col-md-4 col-sm-6 col-xs-6\">
                <div class=\"veiling\">
                    <div class=\"veiling-titel label label-default\">" .
        $auction["VW_titel"] . "
                    </div>"
        . "<a href=\"voorwerp.php?ItemID=" . $auction["VW_voorwerpnummer"] . " \">" . "<div class=\"veiling-image\" style=\"background-image:url(" . 'http://iproject3.icasites.nl/thumbnails/' . $auction["ImagePath"] . ")\"></div></a>
                    <div class=\"veiling-prijs-tijd\">
                        <div class=\"prijs label label-default\"><i class=\"glyphicon glyphicon-euro\"></i> " . $auction["prijs"] . "</div>
                        <div class=\"tijd label label-default\">" . "<p id=". $auction["VW_voorwerpnummer"] ."></p>" . " </div>
                    </div>
                    <div class=\"veiling-rating-bied label label-default\">
                        <button class=\"btn text-center btn-default bied\">Meer info</button>
                        <button class=\"btn text-center btn-info bied\">Bied Nu!</button>
                    </div>
                </div>
            </div>
            <!-- End template -->
    ";
    createTimer($auction["VW_looptijdEinde"], $auction["VW_titel"],$auction["VW_voorwerpnummer"]);

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
    $Offset = cleanInput($Offset);

//Prepare the query
    $QuerySearchProducts = <<< EOT
SELECT DISTINCT
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
  Voorwerp.VW_betalingswijze
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
		AND ($SearchCategory IS NULL OR r1.RB_Nummer = $SearchCategory OR r2.RB_Nummer = $SearchCategory OR r3.RB_Nummer = $SearchCategory OR r4.RB_Nummer = $SearchCategory)
		AND (NULL IS NULL OR Voorwerp.VW_betalingswijze like '%%')
	AND (VW_veilinggesloten != 1)
GROUP BY VW_voorwerpnummer, VW_titel, Rubriek.RB_Naam, VW_looptijdEinde, r1.RB_Naam, r2.RB_Naam, VW_betalingswijze,Voorwerp.VW_looptijdStart,
   Voorwerp.VW_looptijdEinde,VW_looptijdStart, VW_looptijdEinde, VW_startprijs, VW_thumbnail
ORDER BY $SearchFilter , VW_voorwerpnummer
OFFSET $Offset ROWS
FETCH NEXT $ResultsPerPage ROWS ONLY

    
EOT;

    print_r($QuerySearchProducts);
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


function printCategoriën($zoekterm, $rubriekNummer,$sorteerfilter,$prijs,$betalingsmethode)
{
    global $connection;
    $rubriekQuery = "SELECT H.RB_Naam AS HoofdRubriek, X.RB_Naam AS Rubriek, Y.RB_Naam AS SubRubriek, Z.RB_Naam as SubSubRubriek, H.RB_Nummer as HoofdRubriekNummer, X.RB_Nummer as RubriekNummer, Y.RB_Nummer AS SubRubriekNummer, Z.RB_Naam as SubSubRubriekNummer
                        FROM Rubriek H
                        OUTER APPLY
                        (
                          SELECT * FROM Rubriek S
                          WHERE S.RB_Parent = H.RB_Nummer
                        ) X
                        OUTER APPLY
                        (
                          SELECT * FROM Rubriek T
                          WHERE T.RB_Parent = X.RB_Nummer
                        ) Y
                        OUTER APPLY
                        (
                          SELECT * FROM Rubriek U
                          WHERE U.RB_Parent = Y.RB_Nummer
                        ) Z
                       /*
                        cross APPLY
                        (
                            select * FROM Voorwerp_Rubriek E
                            INNER JOIN Voorwerp 
                            on Voorwerp.VW_voorwerpnummer = E.VR_Voorwerp_Nummer
                            WHERE E.VR_Rubriek_Nummer = Z.RB_Nummer OR E.VR_Rubriek_Nummer = Y.RB_Nummer OR e.VR_Rubriek_Nummer = X.RB_Nummer
                            )E
                        */                           
                        WHERE H.RB_Parent = -1  /*and VW_titel like '%$zoekterm%'*/ AND ($rubriekNummer IS NULL OR Z.RB_Nummer = $rubriekNummer OR Y.RB_Nummer = $rubriekNummer OR X.RB_Nummer = $rubriekNummer OR H.RB_Nummer = $rubriekNummer)
                        GROUP BY Z.RB_Naam,Y.RB_Naam,X.RB_Naam,H.RB_Naam,Z.RB_Nummer,Y.RB_Nummer,X.RB_Nummer,H.RB_Nummer
                        ORDER BY H.RB_Naam, X.RB_Naam,Y.RB_Naam,Z.RB_Naam";
    $rubrieken = $connection->query($rubriekQuery)->fetchAll(PDO::FETCH_NUM);
    echo '<ul class="nav">';
//Goes through the first dimensional of the array
    for ($i = 0; $i < sizeof($rubrieken); $i++) {
        //Goes through the second dimensional of the array
        for ($j = 0; $j < (sizeof($rubrieken[$i]) / 2); $j++) {
            //If the next value is not set OR the value is the last value a line is printed
            if (!isset($rubrieken[$i][$j + 1]) OR ($j == (sizeof($rubrieken[$i])/2)-1) AND isset($rubrieken[$i][$j])) {

                echo "<a href=" . " ?zoekterm=" . urldecode($zoekterm) . "&categorie=" . urldecode($rubrieken[$i][$j+4]) . "&sorteerfilter=" . urlencode($sorteerfilter) . "&prijs=" . $prijs["min"] . urlencode(",") . $prijs["max"] . "&betalingsmethode=" . $betalingsmethode . "&pagenum=".'1'.">";

                echo $rubrieken[$i][$j] . '<span class="badge pull-right">42</span></a><ul> ';
                $j = sizeof($rubrieken[$i]);
            } //If the current rubric is set and is not the same as last rubric a new Unorderd list will be created
            else if ($i <= 0 OR $rubrieken[$i][$j] != $rubrieken[$i - 1][$j] AND isset($rubrieken[$i][$j])) {
                echo '<li><label class="tree-toggle nav-header">' . $rubrieken[$i][$j] . '</label>
                        <ul class="nav nav-list tree" style="display: none;">';
            }
        }
        //For loop to close the list items and unorderd lists it "closes" backwards
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

function createTimer($tijd, $VW_Titel, $VW_Nummer)
{
    //Onzin
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
        
        if(days >= 3){
        document.getElementById("'. $VW_Nummer .'").innerHTML = days + "d " + hours + "h "
            + minutes + "m " ;
        }else if(days < 3 && seconds < 10){
        document.getElementById("'. $VW_Nummer  .'").innerHTML = hours + "h "
            + minutes + "m " + "0" + seconds + "s" ;
        }else{
        document.getElementById("'. $VW_Nummer  .'").innerHTML = hours + "h "
            + minutes + "m " + seconds +  "s" ;
        }
        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("'. $VW_Nummer .'").innerHTML = "Veiling gesloten";
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
            echo $headers;
            $message = '

<html>
<head>
<title>EenmaalAndermaal Registratie</title>
</head>
<body>

<table>
<tr>
<td>Beste gebruiker,</td>
</tr><td>&nbsp;</td></tr>
<tr>
<td>u heeft aangegeven zich aan te willen melden op onze website.</td>
</tr>
</tr><td>&nbsp;</td></tr>
<tr>
<td>Dit is uw persoonlijke code: '.$code. '</td>
</tr>
<tr>
<td>Vul deze in op de website om de registratieprocedure af te ronden of klik op deze <a href="http://iproject3.icasites.nl/registreer1.php?code=' . $urlCode . '">link</a></td>
</tr>
</tr><td>&nbsp;</td></tr>
<tr>
<td>Met vriendelijke groet,</td>
</tr>
</tr><td>&nbsp;</td></tr>
<tr>
<td>Het EenmaalAndermaal Team</td>
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
        } else {
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

            session_destroy();

            echo '  <div class="alert alert-success">
                            <strong>Success!</strong>U bent succesvol geregistreerd op EenmaalAndermaal!</div>';

        }
    } else {
        session_destroy();
        header('Location: registreer1.php');
    }

}

function getCodeFromMail()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo $_GET['code'];
    }


}

?>