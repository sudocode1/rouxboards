<!DOCTYPE html>

<link rel="stylesheet" href="styles.css">

<?php
    include 'connection.php';
?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li style="float: right"><?php echo $navBarUserId ?></li>
</ul>

<body>
<span>
<span style="font-size: 200%">rouxboards</span> <br>

</span>
<br>
<div style="width: 500px; border: 1px solid black">
<span>
<span style="font-size: 120%">Latest Posts</span> <br>
<?php
$r = $conn->query("SELECT * FROM posts ORDER BY postId DESC LIMIT 5");
if ($r->num_rows > 0) {
    while($row = $r->fetch_assoc()) {
        // echo "id: " . $row["userId"]. " - xp: " . $row["xpCount"]. " - level:" . $row["level"]. "<br>";
        echo "<a href='post.php?". $row['postId'] ."'>". $row['postTitle'] ."</a> <span> on <a href='board.php?". $row['board'] ."'>". $row['board'] ."</a></span><br>";
    }
}
?>

</span>
</div>
<br>
<span style="font-size: 150%">board list</span>

<p>

<?php
$res = $conn->query("SELECT * FROM boards");
if ($res->num_rows > 0) {
      while($row = $res->fetch_assoc()) {
          $boardName = $row['boardName'];
          $isNsfw = $row['nsfw'] ? 'nsfw' : '';
          // echo "id: " . $row["userId"]. " - xp: " . $row["xpCount"]. " - level:" . $row["level"]. "<br>";
          echo "<a href='board.php?$boardName'>$boardName</a> <span style='color: red'>$isNsfw</span><br>";
      }
}

?>

</p>
</body>