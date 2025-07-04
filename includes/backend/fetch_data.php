<?php
require 'config.php';
include_once 'functions.php';



//Get all the users
$allUsers = array();
$usersSql = "SELECT * FROM community_people";
$usersResult = $conn->query($usersSql);

if ($usersResult->num_rows > 0) {
    while ($aUser = $usersResult->fetch_assoc()) {
        $user = array();
        $user['username'] = $aUser['username'];
        $user['user_id'] = $aUser['user_id'];
        $user['email'] = $aUser['email'];

        //get the photo and the title of the user being displayed
        $stmt = $conn->prepare("SELECT profile_photo, user_title, bio, user_location, gender, dob, user_role FROM user_profile WHERE user_id = ?");
        $stmt->bind_param("i", $aUser['user_id']);
        $stmt->execute();
        $theResult = $stmt->get_result();

        if ($theResult->num_rows === 1) {
            $userInfo = $theResult->fetch_assoc();
            $profilePic = $userInfo['profile_photo'];
            $userTitle =  $userInfo['user_title'];
            $userBio =  $userInfo['bio'];
            $userLocation =  $userInfo['user_location'];
            $userDOB = $userInfo['dob'];
            $userGender = $userInfo['gender'];
            $userRole = $userInfo['user_role'];
        } else {
            $profilePic = "https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg";
            $userTitle =  "Unkown";
            $userBio =  "Unkown";
            $userLocation =  "Unkown";
            $userDOB = "Unkown";
            $userGender = "Unkown";
        }

        $userProfile = [
            'email' => $aUser['email'],
            'name' => $aUser['username'],
            'id' => $aUser['user_id'],
            'profile_photo' => $profilePic,
            'title' => $userTitle,
            'dob' => $userDOB,
            'gender' => $userGender,
            'location' => $userLocation,
            'role' => $userRole,
            'bio' => $userBio
        ];

        $allUsers[] = $userProfile;
    }
}
//get posts from database to display on the feed
$postsArray = array();
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
        $category = $post['category'];
        $categoryIcon = '';

        $category = $post['category'];
        $categoryIcon = '';

        switch ($category) {
            case "Community Development":
                $categoryIcon = "foundation";
                break;
            case "Artist Spotlight":
                $categoryIcon = "brush";
                break;
            case "Event":
                $categoryIcon = "calendar_month";
                break;
            case "Project Updates":
                $categoryIcon = "edit_arrow_up";
                break;
            default:
                $categoryIcon = "adaptive_audio_mic";
                break;
        }
        //get post author data
        //first query from the community_people table
        $userStmt = $conn->prepare("SELECT username, user_id FROM community_people WHERE user_id = ?");
        $userStmt->bind_param("i", $post['user_id']);
        $userStmt->execute();

        $userResult = $userStmt->get_result();
        if ($userResult->num_rows === 1) {
            $postAuthor = $userResult->fetch_assoc();

            //then query for user_profile table so as to get role and profile pict
            $profileInfoStmt = $conn->prepare("SELECT profile_photo, user_role FROM user_profile WHERE user_id  = ?");
            $profileInfoStmt->bind_param("i", $post['user_id']);
            $profileInfoStmt->execute();

            $profileInfoResult = $profileInfoStmt->get_result();
            if ($profileInfoResult->num_rows === 1) {
                $postAuthorInfo = $profileInfoResult->fetch_assoc();
            } else {
                $postAuthorInfo = [
                    'profile_photo' => 'https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg',
                    'user_role' => 'Unknown'
                ];
            }
        } else {
            $postAuthor = [
                'username' => 'Unknown',
                'user_id' => NULL
            ];
}

        // get all comments and their count 
$comments = array();

$commentsStmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ?  ORDER BY created_at DESC");
$commentsStmt->bind_param('i', $post['post_id']);
$commentsStmt->execute();
$commentResult = $commentsStmt->get_result();

while ($commentRow = $commentResult->fetch_assoc()) {
    $commentAuthor = null;

    // Search for the comment's author in $allUsers
    foreach ($allUsers as $aUser) {
        if ($aUser['id'] == $commentRow['user_id']) {
            $commentAuthor = [
                'id' => $aUser['id'],
                'name' => $aUser['name'],
                'profile_photo' => $aUser['profile_photo'],
                'role' => $aUser['role']
            ];
            break;
        }
    }

    // Add author info to the comment
    $commentRow['author'] = $commentAuthor ?? [
        'id' => null,
        'name' => 'Unknown',
        'profile_photo' => 'https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg',
        'role' => 'Unknown'
    ];

    $comments[] = $commentRow;
}



        


        $postData = [
            'post_id' => $post['post_id'],
            'title' => $post['title'],
            'content' => $post['content'],
            'media_url' => $post['media_url'],
            'date' => $post['created_at'],
            'category' => $post['category'],
            'categoryIcon' => $categoryIcon,
            'author' => [
                'name' => $postAuthor['username'],
                'id' => $postAuthor['user_id'],
                'profile_photo' => $postAuthorInfo['profile_photo'],
                'user_role' => $postAuthorInfo['user_role']
            ],
            'comment_count' => count($comments),
            'comments' => $comments

        ];


        $postsArray[] = $postData;
    }
}

$result->free();
$conn->close();