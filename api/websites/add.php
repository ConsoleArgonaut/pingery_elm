<?php

//This is the api to add a website
//GET-Parameters: URL & Name
$urlToAdd = $_GET['URL'];
$nameToAdd = $_GET['Name'];

include("..\\..\\config.php");

if (!isset($conn)){
    $conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
        PDO::ATTR_PERSISTENT => true
    ));
}

$sql = $conn->prepare("SELECT * FROM elm_websites WHERE `URL` = ?;");
$sql->bindParam(1, $urlToAdd);
$sql->execute();
if ($sql->rowCount() == 0){
    $sql = $conn->prepare("INSERT INTO elm_websites (`Name`, `URL`)
        VALUES
        (?, ?);");
    $sql->bindParam(1, $nameToAdd);
    $sql->bindParam(2, $urlToAdd);
    $pages = $sql->execute();
    $sql = $conn->prepare("INSERT INTO elm_log (`websitesFK`)
            VALUE
            ((SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?));");
    $sql->bindParam(1, $urlToAdd);
    $sql->execute();
}
?>