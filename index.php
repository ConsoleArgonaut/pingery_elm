<?php
session_start();
// This file is the main file of pingery elm
// This file is used to show the log and execute the website checks
// IMPORTANT DO NOT CREATE ANY FUNCTIONS!!!
include("config.php");
$conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
    PDO::ATTR_PERSISTENT => true
));
$sql = $conn->prepare("SET NAMES utf8;");
$sql->execute();
$sql1 = $conn->prepare("SELECT * FROM elm_log;");
if ($sql1->execute() == FALSE){
    $sql = $conn->prepare("CREATE TABLE `elm_websites` (
        `websitesId` int(11) NOT NULL,
        `Name` varchar(255) NOT NULL,
        `URL` varchar(255) NOT NULL,
        `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $sql->execute();

    $sql = $conn->prepare("CREATE TABLE `elm_log` (
        `logId` int(11) NOT NULL,
        `websitesFK` int(11) DEFAULT NULL,
        `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `Message` varchar(255) NOT NULL,
        `Success` BOOLEAN,
        `callerIP` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $sql->execute();
}

shell_exec('ping '.$URL);

//Code to create HMTL page content
//Replaces default values in index.html
$HTML = file_get_contents('html/index.html', FILE_USE_INCLUDE_PATH);
$HTML = str_replace('[elm_Login_Text]', 'Manage Websites', $HTML);
$HTML = str_replace('[elm_Page_NavBar]', '<a class="active">Pingery elm</a>', $HTML);

//Replace this with log information!!!
$HTMLContent = '';

//Gives out the html
$HTML = str_replace('[elm_Page_Content]', $HTMLContent, $HTML);
echo $HTML;

?>