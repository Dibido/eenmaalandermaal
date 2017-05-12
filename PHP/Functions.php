<?php

/*function for cleaning user input*/
function cleanInput($input)
{
    $input = strip_tags($input);
    $input = trim($input);
    $input = str_replace("'", "''", $input);
    return $input;
}

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

