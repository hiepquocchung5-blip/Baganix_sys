<!-- 
  🌟 Baganix Login / Registration UI
  File: user-web/pages/login.php
-->
<div class="auth-wrapper" style="text-align: center; margin-top: 20px; overflow: hidden; position: relative; min-height: 450px;">
    <!-- Logo placeholder -->
    <h1 style="font-size: 3rem; margin-bottom: 10px; font-weight: 700; letter-spacing: -1px;">Baganix</h1>
    <p style="color: var(--text-muted); margin-bottom: 40px; font-size: 1.1rem;">The next generation ecosystem.</p>

    <!-- Login Form -->
    <div id="loginFormContainer" style="transition: transform 0.4s ease-in-out; position: absolute; width: 100%; top: 120px; left: 0;">
        <input type="email" id="email" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required>
        <input type="password" id="password" class="bgnx-input" placeholder="Password (စကားဝှက်)" required>
        
        <button id="loginBtn" class="bgnx-btn">Sign In (ဝင်ရောက်မည်)</button>
        
        <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
            Don't have an account? <a href="#" id="showRegister" style="color: white; font-weight: bold;">Create one</a>
        </p>
    </div>

    <!-- Registration Form (Hidden initially) -->
    <div id="registerFormContainer" style="transition: transform 0.4s ease-in-out; transform: translateX(120%); position: absolute; width: 100%; top: 120px; left: 0;">
        <input type="text" id="regUsername" class="bgnx-input" placeholder="Username (အမည်)" required>
        <input type="email" id="regEmail" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required>
        <input type="password" id="regPassword" class="bgnx-input" placeholder="Password (စကားဝှက်)" required>
        
        <button id="registerBtn" class="bgnx-btn">Sign Up (စာရင်းသွင်းမည်)</button>
        
        <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
            Already have an account? <a href="#" id="showLogin" style="color: white; font-weight: bold;">Sign In</a>
        </p>
    </div>
</div>

<script>
    // Pure JS UI Toggle for the Auth Forms
    document.getElementById('showRegister').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('loginFormContainer').style.transform = 'translateX(-120%)';
        document.getElementById('registerFormContainer').style.transform = 'translateX(0)';
    });

    document.getElementById('showLogin').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('registerFormContainer').style.transform = 'translateX(120%)';
        document.getElementById('loginFormContainer').style.transform = 'translateX(0)';
    });
</script>