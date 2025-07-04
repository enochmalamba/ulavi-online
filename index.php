<?php
// session starts with config.php 
require_once('includes/backend/init.php');
require_once('includes/backend/config.php');
require_once('includes/backend/functions.php');

if (isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    get_profile();
    header("Location: ./home.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <script>
    // Pass the CSRF token to JavaScript
    const CSRF_TOKEN = "<?php echo $_SESSION['csrf_token']; ?>";
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ULAVi.online - Celebrating African Creativity</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    :root {
        --bg: #f1f1f1;
        --bg2: #f9f8f6;
        --font: #000;
        --grey: #f1f1f1;
        --card-bg: #fff;
        --text: #333;
        --accent: #555;
        --white: #fff;
        --purple: purple;
        --purple-faded: rgba(128, 0, 128, 0.5);
        --shadow: rgba(0, 0, 0, 0.2);
    }

    .dark-theme {
        --bg: #111;
        --bg2: #000;
        --font: #fff;
        --grey: #222;
        --card-bg: #333;
        --text: #fff;
        --accent: #aaa;
        --white: #fff;
        --purple: rgb(192, 48, 192);
        --purple-faded: rgba(160, 33, 160, 0.5);
        --shadow: rgba(255, 255, 255, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, var(--bg) 0%, var(--bg2) 100%);
        color: var(--font);
        line-height: 1.6;
        min-height: 100vh;
        transition: all 0.3s ease;
    }

    .sticky-nav {
        position: fixed;
        top: -100px;
        left: 0;
        width: 100%;
        background: var(--card-bg);
        box-shadow: 0 2px 10px var(--shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        z-index: 1000;
        transition: top 0.3s ease
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 40px;
        animation: fadeInDown 1s ease-out;
    }

    .logo {
        font-size: 3.5em;
        font-weight: bold;
        background: linear-gradient(45deg, var(--purple), #ff6b35, #f7931e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px var(--shadow);
    }

    .tagline {
        font-size: 1.2em;
        color: var(--accent);
        font-style: italic;
        margin-bottom: 20px;
    }

    .theme-toggle {
        background: var(--purple);
        color: var(--white);
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 0.9em;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px var(--shadow);
    }

    .theme-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px var(--shadow);
    }

    .card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px var(--shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--purple), #ff6b35, #f7931e);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px var(--shadow);
    }

    .card h2 {
        color: var(--text);
        margin-bottom: 20px;
        font-size: 1.8em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card p {
        color: var(--text);
        margin-bottom: 15px;
        font-size: 1.1em;
    }

    .highlight {
        background: linear-gradient(120deg, var(--purple-faded) 0%, transparent 100%);
        padding: 20px;
        border-radius: 15px;
        border-left: 4px solid var(--purple);
        margin: 20px 0;
    }

    .roadmap {
        display: grid;
        gap: 15px;
        margin-top: 20px;
    }

    .roadmap-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: var(--bg2);
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .roadmap-item:hover {
        transform: translateX(5px);
        border-left-color: var(--purple);
    }

    .roadmap-item.completed {
        border-left-color: #4CAF50;
    }

    .roadmap-item.in-progress {
        border-left-color: #FF9800;
    }

    .roadmap-item.planned {
        border-left-color: var(--purple);
    }

    .roadmap-icon {
        font-size: 1.5em;
        margin-right: 15px;
        min-width: 30px;
    }

    .cta-section {
        text-align: center;

        border-radius: 20px;
        padding: 40px;
        margin-top: 40px;
    }

    .cta-button {
        display: inline-block;
        background: linear-gradient(45deg, var(--purple), #ff6b35);
        color: var(--white);
        text-decoration: none;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: bold;
        margin: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px var(--shadow);
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow);
    }

    .local-flavor {
        font-style: italic;
        color: var(--purple);
        font-weight: bold;
        margin: 15px 0;
        text-align: center;
        font-size: 1.1em;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.8s ease-out;
    }

    @media (max-width: 768px) {
        .logo {
            font-size: 2.5em;
        }

        .card {
            padding: 20px;
        }

        .grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="sticky-nav">
        <div class="logo" style="font-size: 1rem;">ULAVi.online</div>
        <a href="index.html" class="cta-button">
            <i class='bx bx-rocket'></i> Explore Community
        </a>
    </div>
    <div class="container">
        <div class="header">
            <div class="logo">ULAVi.online</div>
            <div class="tagline">Celebrating Modern African Creativity & Urban Culture</div>
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class='bx bx-moon'></i> Toggle Theme
            </button>
        </div>

        <div class="card">
            <h2><i class='bx bx-rocket'></i> Welcome, Early Pioneers!</h2>
            <p>Zikomo kwambiri for visiting ULAVi.online (UO)! You're among the first to experience our platform as it
                takes shape. We're still building, which means you might encounter bugs, incomplete features, or rough
                edges along the way.</p>

            <div class="highlight">
                <p><strong>Found something that doesn't work quite right?</strong> We'd love to hear about it! Your
                    feedback helps us create something truly special for the African creative community.</p>
            </div>

            <p>Think of this as getting backstage access to watch something amazing come to life. Every click, every
                test, every piece of feedback you share helps us build a platform that truly serves our vibrant creative
                community.</p>
            <a href="start.html" class="cta-button">
                <i class='bx bx-rocket'></i> Explore Platform
            </a>
        </div>

        <div class="grid">
            <div class="card">
                <h2><i class='bx bx-bullseye'></i> Our Mission</h2>
                <p>ULAVi.online is more than just another platform – it's a digital home where African creatives can
                    showcase their brilliance, connect with like-minded artists, and access the support they deserve.
                </p>

                <p>We're blending cutting-edge technology with the rich tapestry of African culture. Think vibrant urban
                    energy meeting innovative storytelling, where tradition dances with tomorrow's possibilities.</p>

                <p>This is where Malawi's urban vibes meet global resonance, where creativity knows no borders, and
                    where every artist's voice can find its audience.</p>
            </div>

            <div class="card">
                <h2><i class='bx bx-world'></i> Community Goals</h2>
                <p><strong>Empowerment First:</strong> We're creating space for artists and creators from
                    underrepresented backgrounds to shine without compromise.</p>

                <p><strong>Global Malawi:</strong> Showcasing Malawi's incredible urban culture in ways that resonate
                    worldwide while staying authentically rooted.</p>

                <p><strong>Open Collaboration:</strong> Our open-source approach means the community shapes the
                    platform's future together.</p>

                <p><strong>Artist-Centric Tools:</strong> Everything we build prioritizes security, usability, and what
                    creators actually need to succeed.</p>

                <p><strong>Cultural Bridge:</strong> Fostering cross-border connections that celebrate our diversity
                    while building creative solidarity.</p>
            </div>
        </div>

        <div class="card">
            <h2><i class='bx bx-trending-up'></i> Development Roadmap</h2>
            <div class="roadmap">
                <div class="roadmap-item completed">
                    <span class="roadmap-icon"><i class='bx bx-check'></i></span>
                    <span>Secure user authentication and session management</span>
                </div>
                <div class="roadmap-item completed">
                    <span class="roadmap-icon"><i class='bx bx-check'></i></span>
                    <span>File uploads with MySQL integration</span>
                </div>
                <div class="roadmap-item completed">
                    <span class="roadmap-icon"><i class='bx bx-check'></i></span>
                    <span>Dynamic post display and category filters</span>
                </div>
                <div class="roadmap-item in-progress">
                    <span class="roadmap-icon"><i class='bx bx-wrench'></i></span>
                    <span>Bug report system with community voting</span>
                </div>
                <div class="roadmap-item in-progress">
                    <span class="roadmap-icon"><i class='bx bx-cog'></i></span>
                    <span>Artist portfolios and sponsorship requests</span>
                </div>
                <div class="roadmap-item in-progress">
                    <span class="roadmap-icon"><i class='bx bx-envelope'></i></span>
                    <span>Messaging and commenting system</span>
                </div>
                <div class="roadmap-item planned">
                    <span class="roadmap-icon"><i class='bx bx-music'></i></span>
                    <span>Music and video upload support</span>
                </div>
                <div class="roadmap-item planned">
                    <span class="roadmap-icon"><i class='bx bx-globe'></i></span>
                    <span>Multilingual support</span>
                </div>
                <div class="roadmap-item planned">
                    <span class="roadmap-icon"><i class='bx bx-mobile'></i></span>
                    <span>MObile app development for Android and iOS</span>
                </div>
            </div>
        </div>

        <div class="cta-section card">
            <h2><i class='bx bx-group'></i> Join the Movement</h2>
            <p>ULAVi.online is open source because creativity thrives in community. Whether you're a developer who codes
                in their sleep, a designer with an eye for beauty, or a storyteller with fire in your words – we need
                you.</p>

            <div class="local-flavor">
                "Wonders shall never end" – Magret Jumbo
            </div>



            <div style="margin-top: 30px;">
                <a href="start.html" class="cta-button">
                    <i class='bx bx-rocket'></i> Explore Platform
                </a>
                <a href="https://github.com/enochmalamba/ulavi-online" class="cta-button">
                    <i class='bx bxl-github'></i> Contribute on GitHub
                </a>
                <a href="mailto:enochmalamba@gmail.com" class="cta-button">
                    <i class='bx bx-envelope'></i> Get in Touch
                </a>
            </div>

            <p style="margin-top: 30px; font-size: 0.9em; opacity: 0.8;">
                Built with <i class='bx bx-heart' style='color: red'></i> for the African creative community<br>
                Open source • Community-driven • Culture-first
            </p>
            <p><a href="community_guidelines.html" style="font-size: 0.9em; opacity: 0.8;">Community
                    Guidelines</a>&nbsp;|&nbsp;<a href="privacy_policy.html"
                    style="font-size: 0.9em; opacity: 0.8;">Privacy Policy</a>&nbsp;|&nbsp;<a
                    href="terms_of_service.html" style="font-size: 0.9em; opacity: 0.8;">Terms of Service</a></p>
        </div>
    </div>

    <script>
    function toggleTheme() {
        document.body.classList.toggle('dark-theme');
        const button = document.querySelector('.theme-toggle');
        const icon = button.querySelector('i');
        if (document.body.classList.contains('dark-theme')) {
            localStorage.setItem("theme", "dark");
            icon.className = 'bx bx-sun';
        } else {
            icon.className = 'bx bx-moon';
            localStorage.setItem("theme", "light");
        }
    }

    // Add some interactive animations
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
    </script>
    <script src="includes/js/main.js"></script>
    <script src="includes/js/modals.js"></script>
</body>

</html>