<?php
/**
 * 🌟 Baganix Official Landing Page
 * Domain: baganix.online
 * Purpose: Showcase features and redirect users to w.baganix.online
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baganix | The Next-Gen Social Ecosystem</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Padauk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --color-1: #1E90FF;
            --color-2: #FF69B4;
            --bg-dark: #0f0f1a;
            --text-main: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', 'Padauk', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-main); overflow-x: hidden; }
        
        /* Navbar */
        nav { display: flex; justify-content: space-between; padding: 20px 50px; align-items: center; backdrop-filter: blur(10px); position: fixed; width: 100%; z-index: 100; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .logo { font-size: 24px; font-weight: 800; letter-spacing: -1px; background: linear-gradient(135deg, var(--color-1), var(--color-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links a { color: white; text-decoration: none; margin-left: 30px; font-weight: 500; transition: 0.3s; }
        .nav-links a:hover { opacity: 0.7; }
        
        /* Hero Section */
        .hero { height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; position: relative; padding: 0 20px; }
        .hero-bg { position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 50% 50%, rgba(30,144,255,0.15), transparent 40%), radial-gradient(circle at 80% 20%, rgba(255,105,180,0.15), transparent 40%); filter: blur(80px); z-index: -1; animation: auroraMove 20s infinite alternate ease-in-out; }
        @keyframes auroraMove { 0% { transform: rotate(0deg) scale(1); } 100% { transform: rotate(15deg) scale(1.1); } }
        
        .hero h1 { font-size: 5rem; font-weight: 800; margin-bottom: 20px; line-height: 1.1; }
        .hero p { font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 600px; margin-bottom: 40px; line-height: 1.6; }
        
        /* Buttons */
        .btn { padding: 15px 35px; border-radius: 30px; font-size: 1.1rem; font-weight: 600; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; display: inline-block; cursor: pointer; }
        .btn-primary { background: linear-gradient(135deg, var(--color-1), var(--color-2)); color: white; box-shadow: 0 10px 30px rgba(255,105,180,0.3); border: none; }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(255,105,180,0.5); }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); margin-left: 15px; }
        .btn-secondary:hover { background: rgba(255,255,255,0.2); }
        
        /* Features */
        .features { padding: 100px 50px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto; }
        .feature-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 40px; border-radius: 24px; text-align: left; transition: transform 0.3s; }
        .feature-card:hover { transform: translateY(-10px); background: rgba(255,255,255,0.05); }
        .feature-icon { font-size: 40px; margin-bottom: 20px; background: linear-gradient(135deg, var(--color-1), var(--color-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .feature-card h3 { font-size: 1.5rem; margin-bottom: 15px; }
        .feature-card p { color: rgba(255,255,255,0.6); line-height: 1.6; }

        @media(max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            .nav-links { display: none; }
            nav { padding: 20px; }
            .btn-secondary { margin-left: 0; margin-top: 15px; display: block; }
        }
    </style>
</head>
<body>

    <div class="hero-bg"></div>

    <nav>
        <div class="logo">Baganix</div>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="http://w.baganix.online/?page=login" class="btn btn-primary" style="padding: 10px 25px; margin-left: 30px;">Open App</a>
        </div>
    </nav>

    <section class="hero">
        <h1>Connect Securely.<br>Share Freely.</h1>
        <p>The next-generation social ecosystem built for Myanmar and the World. Experience true end-to-end encrypted chats and a beautifully customized feed.</p>
        <div>
            <!-- Direct routing to the user-web portal -->
            <a href="http://w.baganix.online/?page=login" class="btn btn-primary">Launch Web App</a>
            <a href="#features" class="btn btn-secondary">Explore Features</a>
        </div>
    </section>

    <section id="features" class="features">
        <div class="feature-card">
            <i class="fa-solid fa-shield-halved feature-icon"></i>
            <h3>E2EE Chat Vault</h3>
            <p>Your privacy is absolute. Our Bind-Hash architecture ensures even our servers cannot read your messages. Only you hold the key.</p>
        </div>
        <div class="feature-card">
            <i class="fa-solid fa-layer-group feature-icon"></i>
            <h3>Zat-Lan Feed</h3>
            <p>A beautifully curated feed powered by Aurora Glass. Share text, images, and reels in a completely new, immersive way.</p>
        </div>
        <div class="feature-card">
            <i class="fa-solid fa-palette feature-icon"></i>
            <h3>Aura Customization</h3>
            <p>Your profile, your colors. Choose your digital aura and watch the entire app seamlessly adapt to your unique personality.</p>
        </div>
    </section>

    <footer style="text-align: center; padding: 50px; border-top: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.5);">
        &copy; 2026 Baganix. All rights reserved. <br>
        <span style="font-size: 0.8rem;">API & Admin portals are restricted.</span>
    </footer>

</body>
</html>