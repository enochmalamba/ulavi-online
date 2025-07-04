<?php
// session starts with config.php 
require_once('includes/backend/init.php');
require_once('includes/backend/config.php');
require_once('includes/backend/functions.php');

if (!isset($_SESSION['user_id']) || !validate_session()) {
    header("Location: signup.php");
    exit();
}

// Generate token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/user_info.css">
    <title>Account Registration</title>
</head>

<body>
    <form action="includes/backend/user_info_submit.php" method="POST" enctype="multipart/form-data" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="info">
            <h2 class="title">Tell us a bit about you!</h2>
            <p>Let's get to know you better so we can make your experience super awesome!</p>
        </div>
        <div class="inputs">
            <label for="birthday">When where you born?🎂</label>
            <input type="date" name="birthday" required>
            <label for="location">Where are you from? 🌍</label>
            <input type="text" name="location" placeholder="Are you from Blantre, Lilongwe, etc?" required>
            <label for="gender">What is your gender? 💫</label>
            <select name="gender" id="gender" required>
                <option disabled selected value>--Select your identity--</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
                <option value="Hidden">Prefer not to say</option>
            </select>
            <button type="submit" name="enter_user_data1">Next Step → Let's create your profile</button>
        </div>
    </form>
</body>

</html>