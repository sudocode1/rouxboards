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
    && array_key_exists('board', $_POST)
    && array_key_exists('postId', $_POST)
    ) {

    $text = $_POST['text'];
    $board = $_POST['board'];
    $postId = $_POST['postId'];

    if (strpos($text, "'") || strpos($board, "'") || strpos($postId, "'") || strpos($ip, "'")) {
        die('no');
    }
    if (strpos($text, "<") || strpos($board, "<") || strpos($postId, "<") || strpos($ip, "<")) {
        die('no');
    }
    
    if (strpos($text, ">") || strpos($board, ">") || strpos($postId, ">") || strpos($ip, ">")) {
        die('no');
    }

    if (strlen($text) > 1000) {
        die('no comments over 1000 characters');
    }

    if ($userId == 0) {
        die('user error');
    }

    

    // if (!$res->num_rows) {
    //     die('does not exist');
    // }

    // $postData = $res->fetch_assoc();
    $resultDataRaw = $conn->query("SELECT * FROM comments ORDER BY commentId DESC");
    $result = $conn->query("SELECT * FROM comments ORDER BY commentId DESC")->fetch_assoc();

    var_dump($resultDataRaw->num_rows);

    if (!$resultDataRaw->num_rows) {
        $commentId = 1;
    } else {
        $commentId = (int)$result['commentId']+1;
    }

    $conn->query("INSERT INTO comments (postId, userId, commentText, commentId) VALUES ($postId, $userId, '$text', $commentId)");
    
    // send help
    $commentsForUI = $conn->query("SELECT * FROM comments WHERE postId = $postId ORDER BY commentId DESC");
    $postForUI = $conn->query("SELECT * FROM posts WHERE postId = $postId")->fetch_assoc();
    
} else {
    die('no post request');
}

?>

<span>
<span style="font-size: 200%"><?php echo $postForUI['postTitle'] ?></span> <br>
<span style="font-size: 100%"><a href="../board.php?<?php echo $postForUI['board'] ?>"><?php echo $postForUI['board'] ?></a></span>
<span style="font-size: 100%"><a href="../profile.php?<?php echo $postForUI['userId'] ?>"><?php echo $postForUI['userId'] ?></a></span>

</span> <Br> <Br>
<span style="font-size: 130%"><?php echo $text ?></span>

<br><BR>
<span>This is not the actual post page, this is a form redirect, click <a href="../post.php?<?php echo $postId ?>">here</a> to go there.</span>
<br> <br>
<?php 

if ($commentsForUI->num_rows > 0) {
      while($row = $commentsForUI->fetch_assoc()) {
        $commenterUserId = $row['userId'];
        $commenterCommentData = $row['commentText'];

        echo "<span><span style='font-size: 100%'><a href='../profile.php?". $commenterUserId ."'>$commenterUserId</a></span><br>$commenterCommentData</span><br><Br>";
      }
}


?>
</body>