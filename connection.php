<?php
// axton are you happy now
$conn = new mysqli("localhost", "root", "", "board");
echo '<title>rouxboards</title>';

$ip = $_SERVER['REMOTE_ADDR'];

$dataNoFetch = $conn->query("SELECT * FROM users WHERE ip = '$ip'");
$data = $conn->query("SELECT * FROM users WHERE ip = '$ip'")->fetch_assoc();

if (!$dataNoFetch->num_rows) {
    $userId = 0;
    $navBarUserId = "<a href='signup.php'>Create Profile</a>";
} else {
    $userId = $data['userId'];
    $navBarUserId = "<a href='profile.php?$userId'>$userId</a>'";
}

if ($userId) {
    if ($data['suspended']) {
        die('<h1 style="color: red">Your account has been suspended, contact @sudocode1_ on Twitter to appeal. Your ID is '. $userId . '.</h1>');
    }
}

?>
