<?php
// session starts with config.php 
require_once 'init.php';
require_once 'config.php';
require_once 'functions.php';

if (isset($_POST['comment'])) {
    $comment = sanitize_input($_POST['comment']);
    $postID = intval($_POST['post_id']);
    $userID = intval($_SESSION['user_id']);
    $commentStmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?) ");
    $commentStmt->bind_param("iis", $postID, $userID, $comment);
    if ($commentStmt->execute()) {
        echo "<script>
                window.location.href = '../../post.php?post_id=$postID';
</script>";
} else {
echo "<script>
alert('Error: " . $conn->error . "');
</script>";
}
}