<!DOCTYPE html>

<link rel="stylesheet" href="styles.css">

<?php
$conn = new mysqli("localhost", "root", "", "board");

if (isset($_POST['sm']) && array_key_exists('description', $_POST)) {

    $idNumber = round(rand(1, 100000000));
    $description = $_POST['description'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if (strpos($description, "'") || strpos($ip, "'")) {
        die('no');
    }

    if (strpos($description, "<") || strpos($ip, "<")) {
        die('no');
    }
    
    if (strpos($description, ">") || strpos($ip, ">")) {
        die('no');
    }

    $res = $conn->query("SELECT * FROM users WHERE ip = '$ip'")->fetch_assoc();
    if ($res) {
        die('already registered');
    }

    echo 'your id is: '.$idNumber.'<br>';

    $conn->query("INSERT INTO users (userId, descrip, postCount, verified, staff, ip, suspended) VALUES ('$idNumber', '$description', 0, 0, 0, '$ip', 0)");

    die('submitted <a href="index.php">go back</a>');
    
}
?>

<h1>there are no usernames, you will be assigned an ID.</h1>
<form action="" method="post">
Description <br>
<input name="description" type="text"> <br>
<input name="sm" type="submit" value="submit">
</form>