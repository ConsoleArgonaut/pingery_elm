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

//Gets Content from API
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$getApiUrl = explode("/manage.php", $currentUrl)[0] . '/api/websites/get.php';
$websites = json_decode(file_get_contents($getApiUrl), true);

//Placeholders, replace with the actual code (like above)
$timeDate = '20.12.2012 12:34:56';
$online = 'Ja';
$message = 'Diese Webseite funktionierte wieder um 24:23:22 Uhr.';

foreach($websites as $url => $name) {
    $HTMLContent = $HTMLContent .
        '<tr>'.
            '<td style="text-align: left;">'.
                '<div style="color:black"><a style="color:black" href="' . $url . '">'. $name . '</a> &nbsp;&nbsp;'.

            '</td>'.

            '<td style="text-align: left;">'.
                $url.
            '</td>'.

            '<td style="text-align: center;">'.
                $timeDate.
            '</td>'.

            '<td style="text-align: center;">'.
                $online.
            '</td>'.

            '<td style="text-align: center;">'.
            '<div style="color:'.($online == 'Ja' ? 'green' : 'red').'">'.
                $message.
            '</div></td>'.

        '</tr></div>';
}

//Gives out the html
$HTML = str_replace('[elm_Page_Content]', "", $HTML);
echo $HTML;

?>
<div style=" margin-left: 15%; margin-right: 15%; margin-bottom: 10%">
    <h2>Welcome to Pingery-Elm</h2>
    <br>

    <table style="width:100%" >
        <tr>
            <th><h3>Website</h3></th>
            <th><h3>URL</h3></th>
            <th><h3>date / time</h3></th>
            <th><h3>online</h3></th>
            <th><h3>Message</h3></th>
        </tr>
        <?php echo $HTMLContent; ?>
    </table>

</div>