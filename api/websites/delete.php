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
?>