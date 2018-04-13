<?php
// This file is the main file of pingery elm
// This file is used to show the log and execute the website checks
// IMPORTANT DO NOT CREATE ANY FUNCTIONS!!!





// Add Code here for calling websites and creating the log data





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