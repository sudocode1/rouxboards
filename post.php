<!DOCTYPE html>

<link rel="stylesheet" href="styles.css">

<?php
    include 'connection.php';
?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li style="float: right"><?php echo $navBarUserId ?></li>
</ul>

<?php
$gid = parse_url($_SERVER['REQUEST_URI']);
//var_dump($gid);

// mostly copied from profile.php

if (!$gid["query"]) {
    die('query is missing');
}

$postQuery = $gid["query"];

$viewingDataNoFetch = $conn->query("SELECT * FROM posts WHERE postId = $postQuery");
$viewingData = $conn->query("SELECT * FROM posts WHERE postId = $postQuery")->fetch_assoc();


if (!$viewingDataNoFetch->num_rows) {
    die('<h1>post does not exist</h1>');
} else {
    //$viewingUserId = $postQuery;
}

// if ($viewingData['suspended']) {
//     die('<h1 style="color: red">This user has been suspended.</h1>');
// }


?>

<span>
<span style="font-size: 200%"><?php echo $viewingData['postTitle'] ?></span> <br>
<span style="font-size: 100%"><a href="board.php?<?php echo $viewingData['board'] ?>"><?php echo $viewingData['board'] ?></a></span>
<span style="font-size: 100%"><a href="profile.php?<?php echo $viewingData['userId'] ?>"><?php echo $viewingData['userId'] ?></a></span>



</span> <Br> <Br>
<span style="font-size: 130%"><?php echo $viewingData['postText'] ?></span>

<br> <Br> <BR>

<form action="post/postComment.php" method="post">
Comment <br>
<input type="text" name="text">
<input type="hidden" name="board" value="<?php echo $viewingData['board'] ?>">
<input type="hidden" name="postId" value="<?php echo $viewingData['postId'] ?>">
<input type="submit" name="sm" value="Submit">
</form>

<br>

<?php 
$commentsForUI = $conn->query("SELECT * FROM comments WHERE postId = $postQuery ORDER BY commentId DESC ");
if ($commentsForUI->num_rows > 0) {
      while($row = $commentsForUI->fetch_assoc()) {
        $commenterUserId = $row['userId'];
        $commenterCommentData = $row['commentText'];

        echo "<span><span style='font-size: 100%'><a href='../profile.php?". $commenterUserId ."'>$commenterUserId</a></span><br>$commenterCommentData</span><br><Br>";
      }
}


?>

