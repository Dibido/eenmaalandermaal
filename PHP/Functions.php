<?php

    /*function for cleaning user input*/
    function cleanInput($input){
        $input = strip_tags($input);
        $input = trim($input);
        $input = str_replace("'", "''", $input);
        return $input;
    }



?>

