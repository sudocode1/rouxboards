<!DOCTYPE html>

<?php
    include '../connection.php';
?>

<link rel="stylesheet" href="../styles.css">


<body>

<?php 

if (
    isset($_POST['sm'])
    && array_key_exists('text', $_POST) 
    && array_key_exists('title', $_POST)
    && array_key_exists('board', $_POST)
    ) {

    $text = $_POST['text'];
    $title = $_POST['title'];
    $board = $_POST['board'];

    if ($userId == 0) {
        die('user error');
    }

    if (strpos($text, "'") || strpos($ip, "'") || strpos($title, "'") || strpos($board, "'")) {
        die('no');
    }

    if (strpos($text, "<") || strpos($ip, "<") || strpos($title, "<") || strpos($board, "<")) {
        die('no');
    }
    
    if (strpos($text, ">") || strpos($ip, ">") || strpos($title, ">") || strpos($board, ">")) {
        die('no');
    }

    if (strlen($text) > 4000) {
        die('no comments over 4000 characters');
    }

    // if (!$res->num_rows) {
    //     die('does not exist');
    // }

    // $postData = $res->fetch_assoc();
    $resultDataRaw = $conn->query("SELECT * FROM posts ORDER BY postId DESC");
    $result = $conn->query("SELECT * FROM posts ORDER BY postId DESC")->fetch_assoc();



    if (!$resultDataRaw->num_rows) {
        $postId = 1;
    } else {
        $postId = (int)$result['postId']+1;
    }



    $conn->query("INSERT INTO posts (postId, postTitle, board, userId, likes, postText) VALUES ($postId, '$title', '$board', $userId, 0, '$text')");
    
    $conn->query("UPDATE users SET postCount = postCount + 1 WHERE userId = $userId;");
    
    
} else {
    die('no post request');
}

?>

<span>
<span style="font-size: 200%"><?php echo $title ?></span> <br>
<span style="font-size: 100%"><a href="../board.php?<?php echo $board ?>"><?php echo $board ?></a></span>
<span style="font-size: 100%"><a href="../profile.php?<?php echo $userId ?>"><?php echo $userId ?></a></span>

</span> <Br> <Br>
<span style="font-size: 130%"><?php echo $text ?></span>

<br><BR>
<span>This is not the actual post page, this is a form redirect, click <a href="../post.php?<?php echo $postId ?>">here</a> to go there.</span>

<?php die('') ?>
</body>