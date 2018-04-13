<?php
// This file is the secondary file of pingery elm
// This is file is used to show the different existing websites and give the possibility to delete or add them


//Code to create HMTL page content
//Replaces default values in index.html
$HTML = file_get_contents('html/index.html', FILE_USE_INCLUDE_PATH);
$HTML = str_replace('[elm_Login_Link]', '..\\index.php', $HTML);
$HTML = str_replace('[elm_Login_Text]', 'See log', $HTML);
$HTML = str_replace('[elm_Page_NavBar]', '<a class="active">Pingery elm - Manage websites</a>', $HTML);

//Replace this with:
//- Add / Delete functions for Websites
//- Overview of all Websites
$HTMLContent = '';

//Gets Content from API
$websites = json_decode(file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/api/websites/get.php'), true);

foreach($websites as $url => $name) {
    //@Laura. Overview of all the websites here
    $HTMLContent = $HTMLContent . '<a href="' . $url . '">' . $name . '</a></br>';
}

//Gives out the html
$HTML = str_replace('[elm_Page_Content]', $HTMLContent, $HTML);
echo $HTML;

?>