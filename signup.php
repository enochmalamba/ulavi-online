<?php
require_once('includes/backend/init.php');
require_once('includes/backend/config.php');
require_once('includes/backend/functions.php');


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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/styles/auth.css">
    <link rel="stylesheet" href="includes/styles/main.css">
    <title>Create Account - ULAVi.Online</title>
</head>

<body>
    <div class="auth-container">
        <div class="auth-banner">
            <h1>
                ULAVi.Online <br />
                <span>Join our creative community 🎨 </span>
            </h1>
            <p>Unlock a world of artistic collaboration! Sign up to:</p>
            <ul>
                <li><i class='bx bx-palette'></i> <span><strong>Share Your Artwork:</strong> Showcase your creations and
                        get feedback from fellow artists.</span></li>
                <li><i class='bx bx-paint-roll'></i> <span><strong>Join Community Projects:</strong> Participate in
                        collaborative art initiatives.</span></li>
                <li><i class='bx bx-network-chart'></i> <span><strong>Stay Connected:</strong> Receive updates on events
                        and opportunities.</span></li>
            </ul>
        </div>
        <div class="auth-form">
            <form action="includes/backend/auth.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <h2>Sign up</h2>
                <label for="username">Enter username</label>
                <input type="text" name="username" id="username" required>
                <label for="email">Enter email address</label>
                <input type="email" name="email" id="email" required>
                <label for="Password">Enter password</label>
                <input type="password" name="password" id="Password" min="6" required>
                <span class="switch-form">
                    Already have an account?
                    <a href="signin.php" class="switch-form-btn">Login</a>
                </span>
                <button type="submit" name="signup">Sign up</button>
                <?php if (isset($_SESSION['email_error'])): ?>
                <p class="error-message"><?php echo $_SESSION['email_error']; ?></p>
                <?php unset($_SESSION['email_error']); ?>
                <?php endif; ?>
                <span>By signing up, you agree to our <a href="#">terms and conditions</a> and <a href="#">community
                        guidelines</a></span>
            </form>
        </div>
    </div>
</body>

</html>