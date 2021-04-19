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

    // mostly copied from profile.php

    if (!$gid["query"]) {
        die('query is missing');
    }

    $boardQuery = $gid["query"];

    // board data
    $boardViewingDataNoFetch = $conn->query("SELECT * FROM boards WHERE boardName = '$boardQuery'");
    $boardViewingData = $conn->query("SELECT * FROM boards WHERE boardName = '$boardQuery'")->fetch_assoc();
    
    if (!$boardViewingDataNoFetch->num_rows) {
        die('<h1>board does not exist</h1>');
    } else {
        //$boardViewingData = $boardQuery;
    }

    if ($boardViewingData['restricted'] && !$data['staff']) {
        die('<h1 style="color: red">This board is restricted.</h1>');
    }

    $isNsfw = $boardViewingData['nsfw'] ? 'nsfw' : '';
    // push board data
    ?>

    <span><span style="font-size: 200%; font-weight: bolder"><?php echo $boardViewingData['boardName'] ?></span><br><span style="font-size: 150%"><?php echo $boardViewingData['topic'] ?> <span style="color: red"><?php echo $isNsfw ?></span></span><br><?php echo $boardViewingData['posts'] ?> Posts</span>
    <br> <Br>
    <form action="/post/postPost.php" method="post">
    Post title<br>
    <input name="title" type="text"> <br>
    Post text (must be unique) <BR>
    <input name="text" type="text">
    <input name="board" type="hidden" value="<?php echo $boardQuery ?>">
    <input name="sm" value="Submit" type="submit">
    </form>

    <?php

    // posts & post data
    $postDataNoFetch = $conn->query("SELECT * FROM posts WHERE board = '$boardQuery' ORDER BY postId DESC");
    $postData = $conn->query("SELECT * FROM posts WHERE board = '$boardQuery' ORDER BY postId DESC")->fetch_assoc();

    // push post data | copied from profile
    echo '<Br><Br>';
    if ($postDataNoFetch->num_rows > 0) {
        while($row = $postDataNoFetch->fetch_assoc()) {
            //var_dump($row);
            //echo '<span><span style="font-size: 150%">'. $row['postTitle'] .'</span><br><a style="color: lightgrey" href="profile.php?'. $row['userId'] .'>'. $row['userId'] .'</a><br><br>'. $row['postText'] .'</span>';

            // row is post data

            echo '<div style="border: 1px solid black; padding: 2px; width: 500px">'; //top
            echo '<span style="font-size: 150%"><a href="post.php?'; //title + post link
            echo $row['postId'];//post link href
            echo '">'; // post link href end
            echo $row['postTitle']; //title
            echo '</a>'; // post link end
            echo '</span>'; //title
            echo '<br>'; //nl
            echo '<a href="profile.php?'; //profile
            echo $row['userId']; //profile userid
            echo '">'; //profile
            echo $row['userId']; //profile userid
            echo '</a>'; //profile
            echo '<br>'; //nl
            echo '<span>'; //postText
            echo $row['postText']; //postText
            echo '</span>'; //postText
            echo '</div>'; //top
            echo '<br>';//nl
            
        }
  }
?>
</body>