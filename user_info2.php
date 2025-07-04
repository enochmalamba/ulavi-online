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
    <title>Create Profile</title>
</head>

<body>
    <form action="includes/backend/user_info_submit.php" method="POST" enctype="multipart/form-data" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="info">
            <h2 class="title">Your spotlight awaits! ✨</h2>
            <p> Let's highlight your unique awesomeness and make your presence unforgettable!</p>
        </div>
        <div class="inputs">
            <label for="profile_photo">Add a face to your profile! 📸</label>
            <img src="" alt="Image preview" id="img-preview" class="photo-preview">
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" required>

            <label for="title">What's your profession/hobby? 🎨</label>
            <input type="text" name="title" id="title" placeholder="Are you a designer, developer, artist, etc?"
                required>
            <label for="bio">Write about yourself! 📝</label>
            <textarea id="bio" name="bio"
                placeholder="Hi there! I'm a creative who loves... My passion is... I'm looking to connect with people who..."
                maxlength="500"></textarea>
            <button type="submit" name="enter_user_data2">All Done → Explore the Community! 🚀</button>

        </div>
    </form>

    <script>
    const imgPreview = document.getElementById('img-preview');
    const imgInput = document.getElementById('profile_photo');

    function showPreview() {
        const file = imgInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    imgInput.addEventListener('change', showPreview);
    </script>
</body>


</html>