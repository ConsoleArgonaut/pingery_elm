<?php
//This is the api to delete a website
//GET-Parameters: URL
$urlToDelete = $_GET['URL'];

include("..\\..\\config.php");

if (!isset($conn)){
    $conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
        PDO::ATTR_PERSISTENT => true
    ));
}
$sql = $conn->prepare("DELETE FROM elm_websites WHERE `URL` = ?;");
$sql->bindParam(1, $urlToDelete);
$pages = $sql->execute();

//Redirect to manage.php after execution
$HTML = '<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="refresh" content="0; URL=\'[elm_RefreshURL]\'" />
    </head>
</html>';
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

echo str_replace('[elm_RefreshURL]', explode("/api/websites/delete.php", $currentUrl)[0]. "/manage.php", $HTML);
?>