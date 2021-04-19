<!DOCTYPE html>

<link rel="stylesheet" href="styles.css">

<?php
    // reserve userId, navBarUserId, data, dataNoFetch
    include 'connection.php';
?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li style="float: right"><?php echo $navBarUserId ?></li>
</ul>

<body>
<?php
    $gid = parse_url($_SERVER['REQUEST_URI']);
    //var_dump($gid);

    

    if (!$gid["query"]) {
        die('query is missing');
    }

    $userQuery = $gid["query"];

    $viewingDataNoFetch = $conn->query("SELECT * FROM users WHERE userId = $userQuery");
    $viewingData = $conn->query("SELECT * FROM users WHERE userId = $userQuery")->fetch_assoc();
    
    if (!$viewingDataNoFetch->num_rows) {
        die('<h1>user does not exist</h1>');
    } else {
        $viewingUserId = $userQuery;
    }

    if ($viewingData['suspended']) {
        die('<h1 style="color: red">This user has been suspended.</h1>');
    }
    
?>

<span>
<span style="font-size: 200%"><?php echo $viewingUserId ?></span> <br>
<span style="font-size: 150%">"<?php echo $viewingData['descrip'] ?>"</span>
</span>

<p>
Posts: <?php echo $viewingData['postCount'] ?> <Br>
Verified: <?php echo $viewingData['verified'] ?> <Br>
Staff: <?php echo $viewingData['staff'] ?> <Br>


</p>

<div>

<?php 
// fetch posts
$res = $conn->query("SELECT * FROM posts WHERE userId = $viewingUserId ORDER BY postId DESC");
if ($res->num_rows > 0) {
      while($row = $res->fetch_assoc()) {
          // echo "id: " . $row["userId"]. " - xp: " . $row["xpCount"]. " - level:" . $row["level"]. "<br>";
          echo '<div style="border: 1px solid black; padding: 2px; width: 500px;">Board: <a href="board.php?'. $row['board'] . '">' . $row['board'] . '</a><br><a href="post.php?' . $row['postId'] . '">' . $row['postTitle'] . '</a><br>' . $row['postText'] . '</div><Br>';
      }
}

?>

</div>
</body>