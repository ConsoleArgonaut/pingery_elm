<?php
//This is the api to delete a website
//GET-Parameters: URL

$urlToDelete = $_GET['URL'];
$conn3 = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
    PDO::ATTR_PERSISTENT => true
));
$sql = $conn3->prepare("DELETE FROM elm_websites WHERE `URL` LIKE ?;");
$sql->bindParam(1, $urlToDelete);
$pages = $sql->execute();

?>