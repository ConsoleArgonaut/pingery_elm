<?php
//This is the api to get all websites
//No GET-Parameters

// Defines that this is a Json Web Service
header('Content-Type: application/json');

// Include the config file to access the database connections if necessary
include("..\\..\\config.php");

// if variable $conn isn't set, create a database connection with the variables $elm_Settings_DSN, $elm_Settings_DbUser and $elm_Settings_DbPassword as defined in the config.php file
if (!isset($conn)){
    $conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
        PDO::ATTR_PERSISTENT => true
    ));
}
//Gets Websites from Database
$websites = array();
$sql = $conn->prepare("SELECT * FROM elm_websites;");
$sql->execute();
// add all results to array $pages
$pages = $sql->fetchAll();
foreach ($pages as $page) {
    //$pushObject = $page['URL']." => ".$page['Name'];
    $websites[$page['URL']] = $page['Name'];
    //array_push($websites, $pushObject);
}

// Creation and output of Json data
echo json_encode($websites);
?>