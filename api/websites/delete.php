<?php
//This is the api to delete a website
//GET-Parameters: URL

$urlToDelete = $_GET['URL'];

$sql = $conn->prepare("DELETE FROM elm_websites WHERE `URL` LIKE ?;");
$sql->bindParam(1, $urlToDelete);
$pages = $sql->execute();

?>