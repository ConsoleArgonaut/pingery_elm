<?php
session_start();

// This file is the main file of pingery elm
// This file is used to show the log and execute the website checks
// IMPORTANT DO NOT CREATE ANY FUNCTIONS!!!

//region Default HTML Content
//Code to create HMTL page content
//Replaces default values in index.html
$HTML = file_get_contents('html/index.html', FILE_USE_INCLUDE_PATH);
$HTML = str_replace('[elm_Login_Text]', 'Manage Websites', $HTML);
$HTML = str_replace('[elm_Login_Link]', 'manage.php', $HTML);
$HTML = str_replace('[elm_Page_NavBar]', '<a class="active">Pingery elm</a>', $HTML);

//Replace this with log information!!!
$HTMLContent = '';
//endregion


include("config.php");
if (!isset($conn)){
    $conn = new PDO($elm_Settings_DSN, $elm_Settings_DbUser, $elm_Settings_DbPassword, array(
        PDO::ATTR_PERSISTENT => true
    ));
}
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
        `websitesFK` int(11),
        `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `Message` varchar(255) NOT NULL,
        `Success` BOOLEAN,
        `callerIP` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $sql->execute();
}
$sql = $conn->prepare("SELECT * FROM elm_websites WHERE `Name` = 'Official PHP Website' AND `URL` = 'http://php.net';");
if ($sql->execute() == FALSE){
    $sql = $conn->prepare("INSERT INTO elm_websites (`Name`, `URL`)
        VALUES
        ('Official PHP Website', 'http://php.net');");
    $sql->execute();
    $sql = $conn->prepare("INSERT INTO elm_log (`websitesFK`)
            VALUE
            ((SELECT `websitesId` FROM `elm_websites` WHERE `URL` = 'http://php.net'));");
    $sql->execute();
    $sql = $conn->prepare("SELECT * FROM elm_websites WHERE `Name` = 'Stackoverflow -> questions and answers' AND `URL` = 'https://stackoverflow.com';");
    if ($sql->execute() == FALSE){
        $sql = $conn->prepare("INSERT INTO elm_websites (`Name`, `URL`)
            VALUES
            ('Stackoverflow -> questions and answers', 'https://stackoverflow.com');");
        $sql->execute();
        $sql = $conn->prepare("INSERT INTO elm_log (`websitesFK`)
            VALUE
            ((SELECT `websitesId` FROM `elm_websites` WHERE `URL` = 'https://stackoverflow.com'));");
        $sql->execute();
    }
}

//Code to create HMTL page content
//Replaces default values in index.html
$HTML = file_get_contents('html/index.html', FILE_USE_INCLUDE_PATH);
$HTML = str_replace('[elm_Login_Text]', 'Manage Websites', $HTML);
$HTML = str_replace('[elm_Page_NavBar]', '<a class="active">Pingery elm</a>', $HTML);

//Replace this with log information!!!
$HTMLContent = '';

//Gets Content from API
$currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$getApiUrl = explode("/index.php", $currentUrl)[0] . '/api/websites/get.php';
$websites = json_decode(file_get_contents($getApiUrl), true);

$pages = array();
$sql = $conn->prepare("SELECT * FROM `elm_websites`;");
$sql->execute();
while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
    array_push($pages, $row);
}
foreach ($pages AS $page){
    require_once("html/index.html");
    $errNo = 0;
    $errStr = "";
    $ping = fsockopen($URL, $errNo, $errStr);
    $message = "ERROR: $errNo -> $errStr";
    if (!$ping) {
        $sql = $conn->prepare("SELECT * FROM elm_log WHERE `websitesFK` = (SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?) AND `Message` = ?;");
        $sql->bindParam(1, $page['URL']);
        $sql->bindParam(2, $message);
        if ($sql->execute() == FALSE){
            $sql = $conn->prepare("UPDATE `elm_log`
                SET `Message` = ?, `Success`= FALSE
                WHERE `websitesFK` = (SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?);");
            $sql->bindParam(1, $message);
            $sql->bindParam(2, $page['URL']);
            $sql->execute();
            ?>
            <script>
                // parameters: service_id, template_id, template_parameters
                (function(){
                    emailjs.send("default_service","pinger_elm_alert",{URL: "<?php $page['URL'] ?>", Name: "<?php $page['Name'] ?>"});
                })();
            </script>
            <?php
        }
    } else {
        $sql = $conn->prepare("SELECT * FROM elm_log WHERE `websitesFK` = (SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?) AND `Message` = ?;");
        $sql->bindParam(1, $page['URL']);
        $sql->bindParam(2, $message);
        if ($sql->execute() == FALSE) {
            $sql = $conn->prepare("UPDATE `elm_log`
                SET `Message` = ?, `Success`= FALSE
                WHERE `websitesFK` = (SELECT `websitesId` FROM `elm_websites` WHERE `URL` = ?);");
            $sql->bindParam(1, $message);
            $sql->bindParam(2, $page['URL']);
            $sql->execute();
            ?>
            <script>
                // parameters: service_id, template_id, template_parameters
                (function(){
                    emailjs.send("default_service","pinger_elm_info",{URL: "<?php $page['URL'] ?>", Name: "<?php $page['Name'] ?>"});
                })();
            </script>
            <?php
        }
    }
}

$sql = $conn->prepare("SELECT (SELECT `Name` FROM `elm_websites` W WHERE W.`websitesId` = L.`websitesFK`) AS `Name`, 
                                        (SELECT `URL` FROM `elm_websites` W WHERE W.`websitesId` = L.`websitesFK`) AS `URL`, 
                                        `Timestamp`, 
                                        `Message`, 
                                        `Success` 
                                 FROM elm_log L");
$sites = array();
while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
    array_push($sites, $row);
}

//region HTML Content creation
$HTMLContent = $HTMLContent . '<div style=" margin-left: 15%; margin-right: 15%; margin-bottom: 10%">
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
        [elm_WebsiteOverview]
    </table>
</div>';

$elm_WebsiteOverview = '';
foreach($sites as $url => $name) {
    $elm_WebsiteOverview = $elm_WebsiteOverview .
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
$HTMLContent = str_replace('[elm_WebsiteOverview]', $elm_WebsiteOverview, $HTMLContent);

//Gives out the html
$HTML = str_replace('[elm_Page_Content]', $HTMLContent, $HTML);
echo $HTML;
//endregion

?>