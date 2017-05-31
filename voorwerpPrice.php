<?php

require('PHP/Functions.php');
require('PHP/SQL-Queries.php');
require('PHP/connection.php');

$ItemID = $_GET['ItemID'];

$ItemInfo = GetItemDetails($ItemID);
$ItemInfo = $ItemInfo[0];


?>

                <span id="Price" class="text-center"><i
                        class="glyphicon glyphicon-euro"></i><?php echo $ItemInfo["prijs"]; ?></span>
