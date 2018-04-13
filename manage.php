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
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$getApiUrl = explode("/manage.php", $currentUrl)[0] . '/api/websites/get.php';
$websites = json_decode(file_get_contents($getApiUrl), true);

foreach($websites as $url => $name) {
    //@Laura. Overview of all the websites here
    $HTMLContent = $HTMLContent . '<tr>'.
                                    '<td style="text-align: right;">'.
                                        '<div style="color:black"><a style="color:black" href="' . $url . '">'.$name . '</a>'.
                                    '&nbsp;&nbsp;</td>'.
                                    '<td style="text-align: left;">'.
                                        $url.
                                    '</td>'.
                                  '</tr></div>';
}

//Gives out the html
$HTML = str_replace('[elm_Page_Content]', "", $HTML);
echo $HTML;
?>

<div style="margin-left: 15%; margin-right: 15% ">
    <table style="width:100%" >
        <tr>
            <td><h2>Edit</h2></td>
            <th><h2 >Website overview</h2></th>
        </tr>

        <tr>
            <td>Add Website:</td>
            <th rowspan="6" style="vertical-align: text-top"><?php echo "<table style='width: 100%;'>".$HTMLContent."</table>" ?> </th>
        </tr>

        <form action="index.php?page=elm_Page_Edit" method="post">
            <tr>
                <td><input type="text" id="elm_addPage_Name" value="Example Website" name="elm_addPage_Name" size="42" ></td>
            </tr>

            <tr>
                <td><input type="text" id="elm_addPage_Url" value="www.example-website.com" name="elm_addPage_Url" size="42" ></td>
            </tr>

            <tr>
                <td >
                    <input type="submit" value=" OK " id="elm_addPage_Execute" name="elm_addPage_Execute">
                </td>
            </tr>
        </form>

        <form action="index.php?page=elm_Page_Delete" method="post">
            <tr>
                <td><h2 style="margin-top: 10%">Delete</h2></td>
            </tr>

            <tr>
                <td><input type="text" id="elm_deletePage_Name" value="www.example-webseite.com" name="elm_addPage_Name" size="42" ></td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value=" OK " id="elm_deletePage_Execute" name="elm_deletePage_Execute">
                </td>

            </tr>
        </form>

    </table>
</div>