<?php
session_start();
init();

if(token()) {
    echo "<a href='".$_SESSION["redirect_uri"]."''>Home</a>";
    echo " || <a href='".$_SESSION["redirect_uri"]."?refresh_token=true'>Refresh token</a>";
    echo " || <a href='".$_SESSION["redirect_uri"]."?profile=true'>Profile</a>";
    echo " || <a href='".$_SESSION["redirect_uri"]."?list_email=true'>List Email</a>";
    echo " || <a href='".$_SESSION["redirect_uri"]."?logout=true'>Logout</a><br/><br/>\n\n";
}

if(isset($_GET["logout"])) {
    flush_token();
    echo "Logged out<br/>";
    echo "<a href='".$_SESSION["redirect_uri"]."'>Start new session</a>";
    die();
}
else if(isset($_GET["profile"])) {
    view_profile();
}
else if(isset($_GET["refresh_token"])) {
    refresh_token();
}
else if(isset($_GET["list_email"])) {
    list_email();
}
else if(isset($_GET["view_email"])) {
    view_email();
}
else if(isset($_GET["view_attachments"])) {
    view_attachments();
}
else if(token()) {
    echo "<pre>"; print_r(token()); echo "</pre>";
}
elseif (isset($_GET["code"])) {
    echo "<pre>";print_r($_GET);echo "</pre>";
    $token_request_data = array (
        "grant_type" => "authorization_code",
        "code" => $_GET["code"],
        "redirect_uri" => $_SESSION["redirect_uri"],
        "scope" => implode(" ", $_SESSION["scopes"]),
        "client_id" => $_SESSION["client_id"],
        "client_secret" => $_SESSION["client_secret"]
    );
    $body = http_build_query($token_request_data);
    $response = runCurl($_SESSION["authority"].$_SESSION["token_url"], $body);
    $response = json_decode($response);

    store_token($response);
    file_put_contents("office_active_user_id.txt", get_user_id());
    file_put_contents("office_access_token.txt", $response->access_token);
    header("Location: " . $_SESSION["redirect_uri"]);
}
else {
    $accessUrl = $_SESSION["authority"].$_SESSION["auth_url"];
    echo "<a href='$accessUrl'>Login with Office 365</a>";
}

function view_email() {
    $mailID = $_GET["view_email"];
    $userID = get_user_id();
    $headers = array(
        "User-Agent: php-tutorial/1.0",
        "Authorization: Bearer ".token()->access_token,
        "Accept: application/json",
        "client-request-id: ".makeGuid(),
        "return-client-request-id: true",
        "X-AnchorMailbox: ". get_user_email()
    );
    $outlookApiUrl = $_SESSION["api_url"] . "/Users('$userID')/Messages('$mailID')";
    $response = runCurl($outlookApiUrl, null, $headers);
    $response = explode("\n", trim($response));
    $response = $response[count($response) - 1];
    $response = json_decode($response, true);
    echo "<pre>"; print_r($response); echo "</pre>";
}

function view_attachments() {
    $mailID = $_GET["view_attachments"];
    $folder = "Office-" . md5($mailID);
    if(!file_exists($folder)) {
        mkdir($folder);
    }
    $userID = get_user_id();
    $headers = array(
        "User-Agent: php-tutorial/1.0",
        "Authorization: Bearer ".token()->access_token,
        "Accept: application/json",
        "client-request-id: ".makeGuid(),
        "return-client-request-id: true",
        "X-AnchorMailbox: ". get_user_email()
    );
    $outlookApiUrl = $_SESSION["api_url"] . "/Users('$userID')/Messages('$mailID')/Attachments";
    $response = runCurl($outlookApiUrl, null, $headers);
    $response = explode("\n", trim($response));
    $response = $response[count($response) - 1];
    $response = json_decode($response, true);
    $file_links = "";
    foreach ($response["value"] as $attachment) {
        $to_file = $folder . "/" . md5($attachment["ContentId"]) . "-" . $attachment["Name"];
        file_put_contents($to_file, base64_decode($attachment["ContentBytes"]));
        if($file_links != "") {
            $file_links = $file_links . " ||| ";
        }
        $file_links .= "<a href='$to_file' target='_blank'>" . $attachment["Name"] . "</a>";
    }
    echo $file_links . "<br/><br/>";
    echo "<pre>"; print_r($response); echo "</pre>";
}

function list_email() {
    $headers = array(
        "User-Agent: php-tutorial/1.0",
        "Authorization: Bearer ".token()->access_token,
        "Accept: application/json",
        "client-request-id: ".makeGuid(),
        "return-client-request-id: true",
        "X-AnchorMailbox: ". get_user_email()
    );
    $top = 2;
    $skip = isset($_GET["skip"]) ? intval($_GET["skip"]) : 0;
    $search = array (
        // Only return selected fields
        "\$select" => "Subject,ReceivedDateTime,Sender,From,ToRecipients,HasAttachments,BodyPreview",
        // Sort by ReceivedDateTime, newest first
        "\$orderby" => "ReceivedDateTime DESC",
        // Return at most n results
        "\$top" => $top, "\$skip" => $skip
    );
    $outlookApiUrl = $_SESSION["api_url"] . "/Me/MailFolders/Inbox/Messages?" . http_build_query($search);
    $response = runCurl($outlookApiUrl, null, $headers);
    $response = explode("\n", trim($response));
    $response = $response[count($response) - 1];
    $response = json_decode($response, true);
    //echo "<pre>"; print_r($response); echo "</pre>";
    if(isset($response["value"]) && count($response["value"]) > 0) {
        echo "<style type='text/css'>td{border: 2px solid #cccccc;padding: 30px;text-align: center;vertical-align: top;}</style>";
        echo "<table style='width: 100%;'><tr><th>From</th><th>Subject</th><th>Preview</th></tr>";
        foreach ($response["value"] as $mail) {
            $BodyPreview = str_replace("\n", "<br/>", $mail["BodyPreview"]);
            echo "<tr>";
            echo "<td>".$mail["From"]["EmailAddress"]["Address"].
                "<br/><a target='_blank' href='?view_email=".$mail["Id"]."'>View Email</a>";
            if($mail["HasAttachments"] == 1) {
                echo "<br/><a target='_blank' href='?view_attachments=".$mail["Id"]."'>View Attachments</a>";
            }
            echo "</td><td>".$mail["Subject"]."</td>";
            echo "<td>".$BodyPreview."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else {
        echo "<div><h3><i>No email found</i></h3></div>";
    }
    $prevLink = "";
    if($skip > 0) {
        $prev = $skip - $top;
        $prevLink = "<a href='?list_email=true&skip=".$prev."'>Previous Page</a>";
    }
    if(isset($response["@odata.nextLink"])) {
        if($prevLink != "") {
            $prevLink .= " ||| ";
        }
        echo "<br/>".$prevLink."<a href='?list_email=true&skip=".($skip + $top)."'>Next Page</a>";
    }
    else {
        echo "<br/>" . $prevLink;
    }
}

function refresh_token() {
    $token_request_data = array (
        "grant_type" => "refresh_token",
        "refresh_token" => token()->refresh_token,
        "redirect_uri" => $_SESSION["redirect_uri"],
        "scope" => implode(" ", $_SESSION["scopes"]),
        "client_id" => $_SESSION["client_id"],
        "client_secret" => $_SESSION["client_secret"]
    );
    $body = http_build_query($token_request_data);
    $response = runCurl($_SESSION["authority"].$_SESSION["token_url"], $body);
    $response = json_decode($response);
    store_token($response);
    file_put_contents("office_access_token.txt", $response->access_token);
    header("Location: " . $_SESSION["redirect_uri"]);
}

function get_user_id() {
    if(isset($_SESSION["user_id"]) && strlen($_SESSION["user_id"]) > 0) {
        return $_SESSION["user_id"];
    }
    view_profile(true);
    $response = json_decode(file_get_contents("office_user_data.txt"));
    $_SESSION["user_id"] = $response->Id;
    return $response->Id;
}

function get_user_email() {
    if(isset($_SESSION["user_email"]) && strlen($_SESSION["user_email"]) > 0) {
        return $_SESSION["user_email"];
    }
    view_profile(true);
    $response = json_decode(file_get_contents("office_user_data.txt"));
    $_SESSION["user_email"] = $response->EmailAddress;
    return $response->EmailAddress;
}

function view_profile($skipPrint = false) {
    $headers = array(
        "User-Agent: php-tutorial/1.0",
        "Authorization: Bearer ".token()->access_token,
        "Accept: application/json",
        "client-request-id: ".makeGuid(),
        "return-client-request-id: true"
    );
    $outlookApiUrl = $_SESSION["api_url"] . "/Me";
    $response = runCurl($outlookApiUrl, null, $headers);
    $response = explode("\n", trim($response));
    $response = $response[count($response) - 1];
    file_put_contents("office_user_data.txt", $response);
    $response = json_decode($response);
    $_SESSION["user_id"] = $response->Id;
    $_SESSION["mail_id"] = $response->MailboxGuid;
    $_SESSION["user_email"] = $response->EmailAddress;
    if(!$skipPrint) {
        echo "<pre>"; print_r($response); echo "</pre>";
    }
}

function makeGuid(){
    if (function_exists('com_create_guid')) {
        error_log("Using 'com_create_guid'.");
        return strtolower(trim(com_create_guid(), '{}'));
    }
    else {
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid, 12, 4).$hyphen
            .substr($charid, 16, 4).$hyphen
            .substr($charid, 20, 12);
        return $uuid;
    }
}

function flush_token() {
    file_put_contents("office_auth_config.txt", "");
    $_SESSION["user_id"] = "";
    $_SESSION["mail_id"] = "";
}

function store_token($o) {
    file_put_contents("office_auth_config.txt", json_encode($o));
}

function token() {
    $text = file_exists("office_auth_config.txt") ? file_get_contents("office_auth_config.txt") : null;
    if($text != null && strlen($text) > 0) {
        return json_decode($text);
    }
    return null;
}

function init() {
    $_SESSION["client_id"] = "da8a54d8-86b5-xxxx-xxxx-e31efa3f3d59";
    $_SESSION["client_secret"] = "pYJAxxxxxxxxxxxxxxxX3vzhfp";
    $_SESSION["redirect_uri"] = "http://localhost/tappi/office.php";
    $_SESSION["authority"] = "https://login.microsoftonline.com";
    $_SESSION["scopes"] = array("offline_access", "openid");
    /* If you need to read email, then need to add following scope */
    if(true) {
        array_push($_SESSION["scopes"], "https://outlook.office.com/mail.read");
    }
    /* If you need to send email, then need to add following scope */
    if(true) {
        array_push($_SESSION["scopes"], "https://outlook.office.com/mail.send");
    }

    $_SESSION["auth_url"] = "/common/oauth2/v2.0/authorize";
    $_SESSION["auth_url"] .= "?client_id=".$_SESSION["client_id"];
    $_SESSION["auth_url"] .= "&redirect_uri=".$_SESSION["redirect_uri"];
    $_SESSION["auth_url"] .= "&response_type=code&scope=".implode(" ", $_SESSION["scopes"]);

    $_SESSION["token_url"] = "/common/oauth2/v2.0/token";

    $_SESSION["api_url"] = "https://outlook.office.com/api/v2.0";
}

function runCurl($url, $post = null, $headers = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, $post == null ? 0 : 1);
    if($post != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if($headers != null) {
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($http_code >= 400) {
        echo "Error executing request to Office365 api with error code=$http_code<br/><br/>\n\n";
        echo "<pre>"; print_r($response); echo "</pre>";
        die();
    }
    return $response;
}
?>