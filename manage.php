<?php
// This file is the secondary file of pingery elm
// This is file is used to show the different existing websites and give the possibility to delete or add them


//region Base HTML Creation
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
//endregion

//region Gets Websites
//Gets Content from API
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$getApiUrl = explode("/manage.php", $currentUrl)[0] . '/api/websites/get.php';
$websites = json_decode(file_get_contents($getApiUrl), true);
//endregion

//region Posts to apis
//Checks if addPage is clicked and sends the data to the api
if(isset($_POST['elm_addPage_Execute'])) {
    $r = new HttpRequest(explode("/api/websites/add.php", $currentUrl)[0]. "/api/websites/add.php?URL=" .$_POST['URL'].'&Name='.$_POST['Name'], HttpRequest::METH_GET);
    $r->send();
}
//Checks if deletePage is clicked and sends the data (whith page) to the api
if(isset($_POST['elm_deletePage_Execute'])) {
    $r = new HttpRequest(explode("/api/websites/delete.php", $currentUrl)[0]. "/api/websites/add.php?URL=" .$_POST['URL'], HttpRequest::METH_GET);
    $r->send();
}
//endregion

//region Description
//region Creation of HTML Content
$HTMLContent = $HTMLContent .
    '<div style="margin-left: 15%; margin-right: 15% ">
        <table style="width:100%" >
            <tr>
                <td>
                    <h2>Edit</h2>
                </td>
                <th>
                    <h2 >Website overview</h2>
                </th>
            </tr>
            <tr>
                <td>Add Website:</td>
                <th rowspan="6" style="vertical-align: text-top"><table style="width: 100%;">
                [elm_WebsiteOverview]
                
                </div>
            </table>
        </th>
    </tr>

    <form action="'. explode("/manage.php", $currentUrl)[0]. "/api/websites/add.php" .'" method="get" target="_blank">
        <tr>
            <td>
                <input type="text" id="elm_addPage_Name" value="Example Website" name="URL" size="42" >
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" id="elm_addPage_Url" value="www.example-website.com" name="Name" size="42" >
            </td>
        </tr>
        <tr>
            <td >
                <input type="submit" value=" OK " id="elm_addPage_Execute" name="elm_addPage_Execute">
            </td>
        </tr>
    </form>
                        
    <form action="'.explode("/manage.php", $currentUrl)[0]. "/api/websites/delete.php".'" method="get" target="_blank">
        <tr>
            <td>
                <h2 style="margin-top: 10%">Delete</h2>
            </td>
        </tr>
                
        <tr>
            <td>
                <input type="text" id="elm_deletePage_Url" value="www.example-webseite.com" name="URL" size="42" >
            </td>
        </tr>
                
        <tr>
            <td>
                <input type="submit" value=" OK " id="elm_deletePage_Execute" name="elm_deletePage_Execute">
            </td>
        </tr>
    </form>

    </table>
</div>';
//endregion

//prints all webpages (overview)
$elm_WebsiteOverview = '';
if($websites != null) {
    foreach($websites as $url => $name) {
        $elm_WebsiteOverview = $elm_WebsiteOverview .
                            '<tr>'.
                                '<td style="text-align: right;">'.
                                    '<div style="color:black"><a style="color:black" href="' . $url . '">'.$name . '</a>
                                    &nbsp;&nbsp;
                                </td>
                                <td style="text-align: left;">'.
                                    $url.
                                '</td>
                            </tr>';
    }
}

$HTMLContent = str_replace('[elm_WebsiteOverview]', $elm_WebsiteOverview, $HTMLContent);

//region Output of HTML Content
//Gives out the html
$HTML = str_replace('[elm_Page_Content]', $HTMLContent, $HTML);
echo $HTML;
//endregion
?>