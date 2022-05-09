@extends('viewmessage')

@section('content')
    <h1>View Message</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">User Name</th>
            <th scope="col">Message Title Subject</th>
            <th scope="col">Email Address</th>
            <th scope="col">Full details</th>
            <th scope="col">Reply</th>
            <th scope="col">attachment</th>
        </tr>
        </thead>

<?PHP

$uploads = 0;
$upload_name = array(); /* Original names */
$upload_temp = array(); /* Temporary names */
$upload_size = array(); /* Size in bytes */
$upload_info = array(); /* Information */

foreach (@$_FILES as $set)
    if (is_array($set["error"])) {
        foreach ($set["error"] as $key => $error)
            if ($error === 0) {
                $uploads++;
                $upload_name[$uploads] = $set["name"];
                $upload_temp[$uploads] = $set["tmp_name"];
                $upload_size[$uploads] = $set["size"];
                $upload_info[$uploads] = array();
            }
    } else
        if ($set["error"] === 0) {
            $uploads++;
            $upload_name[$uploads] = $set["name"];
            $upload_temp[$uploads] = $set["tmp_name"];
            $upload_size[$uploads] = $set["size"];
            $upload_info[$uploads] = array();
        }

for ($u = 1; $u <= $uploads; $u++) {
    $name = $upload_name[$u];
    $upload_name[$u] = FALSE;

    if (($info = @getimagesize($upload_temp[$u])) !== FALSE) {
        switch ($info[2]) {
            case IMAGETYPE_GIF:  $ext = ".gif"; $desc = "GIF image"; break;
            case IMAGETYPE_PNG:  $ext = ".png"; $desc = "PNG image"; break;
            case IMAGETYPE_JPEG: $ext = ".jpg"; $desc = "JPEG image";break;
            default:             $ext = FALSE;
        }
        if ($ext === FALSE)
            continue;

        if ($info[0] < 16 || $info[0] > 4096 ||
            $info[1] < 16 || $info[1] > 4096)
            continue;

        $temp = $name;

        $temp = preg_replace('/^.*\/+/', "", $temp);
        $temp = preg_replace('/\.[^\.]*$/', "", $temp);
        $temp = preg_replace('/[^-0-9A-Z_a-z]+/', "", $temp);
        $temp = preg_replace('/^[^0-9A-Za-z]+/', "", $temp);
        $temp = preg_replace('/[^0-9A-Za-z]+$/', "", $temp);
        if (strlen($temp) < 1)
            continue;

        $upload_info[$u]["original"] = $name;
        $upload_info[$u]["filesize"] = $upload_size[$u];
        $upload_info[$u]["width"] = $info[0];
        $upload_info[$u]["height"] = $info[1];
        $upload_info[$u]["type"] = $info[2];
        $upload_info[$u]["desc"] = $desc;

        /* Note: should check against overwriting existing files here!
        */

        if (@move_uploaded_file($upload_temp[$u], UPLOADS_DIR . "/" . $temp . $ext) !== FALSE)
            $upload_name[$u] = $temp . $ext;
    }
}

for ($u = 1; $u <= $uploads; $u++)
    if ($upload_name[$u] !== FALSE) {
        $url = UPLOADS_URL . "/" . htmlentities($upload_name[$u], ENT_QUOTES, "utf-8");
        echo '<p><a href="', $url, '"><img src="', $url,
        '" width="', $upload_info[$u]["width"],
        '" height="', $upload_info[$u]["height"],
        '" alt="',
        '" title="', htmlentities($upload_info[$u]["original"], ENT_QUOTES, "utf-8"),
        ' - ', $upload_info[$u]["width"], "x", $upload_info[$u]["height"],
        ' ', $upload_info[$u]["desc"], '" border="0">',
        "</a></p>\n";
    }

?>

<form action="upload.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
    <fieldset>
        <legend> Image Upload </legend>
        <input type="file" name="image">
        <input type="submit" value="Upload">
    </fieldset>
</form>

</body>
</html>
