<?php
// This file is the secondary file of pingery elm
// This is file is used to show the different existing websites and give the possibility to delete or add them

//region Base HTML Creation
//Code to create HMTL page content
//Replaces default values in index.html
$HTML = file_get_contents('html/index.html', FILE_USE_INCLUDE_PATH);
$HTML = str_replace('[elm_Login_Link]', 'index.php', $HTML);
$HTML = str_replace('[elm_Login_Text]', 'See log', $HTML);
$HTML = str_replace('[elm_Page_NavBar]', '<a class="active">Pingery elm - Manage websites</a>', $HTML);

$HTMLContent = '';
//endregion

//region Gets Websites
//Gets Content from API
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$getApiUrl = explode("/manage.php", $currentUrl)[0] . '/api/websites/get.php';
$websites = json_decode(file_get_contents($getApiUrl), true);
//endregion

//region Creation of HTML Content
//set and design the table
$HTMLContent = $HTMLContent . file_get_contents('html/contentblocks/ManageViewContainer.html', FILE_USE_INCLUDE_PATH);
//endregion

//prints all webpages (overview)
$ManageViewContent = file_get_contents('html/contentblocks/ManageViewWebsiteOverviewContent.html', FILE_USE_INCLUDE_PATH);

$elm_WebsiteOverview = '';
if($websites != null) {
    foreach($websites as $url => $name) {
        $elm_WebsiteOverview = $elm_WebsiteOverview .
            str_replace('[elm_Website_Name]', $name,
                str_replace('[elm_Website_URL]', $url, $ManageViewContent));
    }
}

$HTMLContent = str_replace('[elm_WebsiteOverview]', $elm_WebsiteOverview, $HTMLContent);

//region Output of HTML Content
//Gives out the html
$HTML = str_replace('[elm_Page_Content]', $HTMLContent, $HTML);
echo $HTML;
//endregion
?>