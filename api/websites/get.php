<?php

//This is the api to get all websites
//No GET-Parameters

// Defines that this is a Json Web Service
header('Content-Type: application/json');

//Gets Websites from Database
//@Enrico, please insert your code here

// Creates array of websites
$websites = array(
    "http://php.net" => "Official PHP Website",
    "https://stackoverflow.com" => "Stackoverflow -> questions and answers"
);

// Creation and output of Json data
echo json_encode($websites);

?>