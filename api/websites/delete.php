<?php
//This is the api to delete a website
//GET-Parameters: URL
$urlToDelete = $_GET['URL'];
<<<<<<< HEAD
$conn3 = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
    PDO::ATTR_PERSISTENT => true
));
$sql = $conn3->prepare("DELETE FROM elm_websites WHERE `URL` LIKE ?;");
=======

$sql = $conn->prepare("DELETE FROM elm_websites WHERE `URL` = ?;");
>>>>>>> develop
$sql->bindParam(1, $urlToDelete);
$pages = $sql->execute();

?>