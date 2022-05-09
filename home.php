<?php
session_start();
$loggedIn = false;
?>

<html>
<head>
    <title>PHP Mail API Tutorial</title>
</head>
<body>
<?php
if (!$loggedIn) {
    ?>
    <!-- User not logged in, prompt for login -->
    <p>Please <a href="#">sign in</a> with your Office 365 account.</p>
    <?php
}
else {
    ?>
    <!-- User is logged in, do something here -->
    <p>Hello user!</p>
    <?php
}
?>
</body>
</html>
