<?php

//This is the api to add a website
//GET-Parameters: URL & Name
$urlToAdd = $_GET['URL'];
$nameToAdd = $_GET['Name'];

// Include the config file to access the database connections if necessary
include("..\\..\\config.php");

// if variable $conn isn't set, create a database connection with the variables $elm_Settings_DSN, $elm_Settings_DbUser and $elm_Settings_DbPassword as defined in the config.php file
if (!isset($conn)){
    $conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
        PDO::ATTR_PERSISTENT => true
    ));
}

// look if provided URL has already been entered into the database in table elm_websites
$sql = $conn->prepare("SELECT * FROM elm_websites WHERE `URL` = ?;");
$sql->bindParam(1, $urlToAdd);
$sql->execute();
// if there isn't any entry the URL will be added to the database in table elm_websites
if ($sql->rowCount() == 0){
    $sql = $conn->prepare("INSERT INTO elm_websites (`Name`, `URL`)
        VALUES
        (?, ?);");
    $sql->bindParam(1, $nameToAdd);
    $sql->bindParam(2, $urlToAdd);
    $pages = $sql->execute();
    // adds the foreign key constraint by adding the appropriate value to table elm_log
    $sql = $conn->prepare("INSERT INTO elm_log (`websitesFK`)
            VALUE
            ((SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?));");
    $sql->bindParam(1, $urlToAdd);
    $sql->execute();
}

//Redirect to manage.php after execution
$HTML = '<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="refresh" content="0; URL=\'[elm_RefreshURL]\'" />
    </head>
</html>';
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

echo str_replace('[elm_RefreshURL]', explode("/api/websites/add.php", $currentUrl)[0]. "/manage.php", $HTML);

?>

