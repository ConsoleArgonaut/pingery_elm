<?php

//This is the api to add a website
//GET-Parameters: URL & Name
$urlToAdd = $_GET['URL'];
$nameToAdd = $_GET['Name'];

$sql = $conn->prepare("SELECT * FROM elm_websites WHERE `URL` = ?;");
$sql->bindParam(1, $urlToAdd);
if ($sql->execute() == FALSE){
    $sql = $conn->prepare("INSERT INTO elm_websites (`Name`, `URL`)
        VALUES
        (?, ?);");
    $sql->bindParam(1, $nameToAdd);
    $sql->bindParam(2, $urlToAdd);
    $pages = $sql->execute();
}
?>