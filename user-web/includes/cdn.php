<!-- 
  🌟 Baganix Centralized Asset Manager
  File: user-web/includes/cdn.php
  Purpose: Manages all external CDNs and local CSS/JS files.
-->

<?php
// Cache-busting version variable. Change this when you update CSS/JS to force browsers to reload.
$bgnx_version = "1.0.0";
?>

<!-- 1. Google Fonts (Premium Typography & Burmese Unicode Support) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Padauk:wght@400;700&display=swap" rel="stylesheet">

<!-- 2. FontAwesome 6 Icons (Modern UI Icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" xintegrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- 3. Animate.css (For smooth loading animations) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- 4. SweetAlert2 (Premium popup notifications replacing standard alerts) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 5. Baganix Local CSS (Aurora Glass UI) -->
<link rel="stylesheet" href="/assets/css/aurora.css?v=<?= $bgnx_version ?>">

<!-- ========================================== -->
<!-- DEFER LOCAL JS SCRIPTS (Loads after DOM)   -->
<!-- ========================================== -->
<!-- E2EE WebCrypto Engine -->
<script src="/assets/js/crypto.js?v=<?= $bgnx_version ?>" defer></script>
<!-- Main App Logic -->
<script src="/assets/js/app.js?v=<?= $bgnx_version ?>" defer></script>

<!-- SweetAlert2 Custom Glass Theme Override -->
<style>
    div.swal2-popup {
        background: rgba(30, 30, 45, 0.85) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 24px !important;
        color: #fff !important;
    }
    .swal2-title { color: #fff !important; font-family: 'Inter', 'Padauk', sans-serif; }
    .swal2-html-container { color: rgba(255,255,255,0.8) !important; font-family: 'Inter', 'Padauk', sans-serif; }
    .swal2-confirm { background: linear-gradient(135deg, #1E90FF, #FF69B4) !important; border-radius: 12px !important; }
</style>