<!-- 
  🌟 Baganix Login / Registration UI
  File: user-web/pages/login.php
-->
<div class="auth-wrapper" style="text-align: center; margin-top: 20px; overflow: hidden; position: relative; min-height: 480px;">
    <!-- Logo placeholder -->
    <h1 style="font-size: 3rem; margin-bottom: 10px; font-weight: 700; letter-spacing: -1px;">Baganix</h1>
    <p style="color: var(--text-muted); margin-bottom: 40px; font-size: 1.1rem;">The next generation ecosystem.</p>

    <!-- Login Form -->
    <div id="loginFormContainer" style="transition: transform 0.4s ease-in-out; position: absolute; width: 100%; top: 120px; left: 0;">
        <form onsubmit="submitLogin(event)">
            <input type="email" id="email" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required>
            <input type="password" id="password" class="bgnx-input" placeholder="Password (စကားဝှက်)" required>
            
            <!-- Type changed to submit so the Enter key works -->
            <button type="submit" class="bgnx-btn">Sign In (ဝင်ရောက်မည်)</button>
            
            <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
                Don't have an account? <a href="#" onclick="toggleAuthForms(event, 'register')" style="color: white; font-weight: bold;">Create one</a>
            </p>
        </form>
    </div>

    <!-- Registration Form (Hidden initially) -->
    <div id="registerFormContainer" style="transition: transform 0.4s ease-in-out; transform: translateX(120%); position: absolute; width: 100%; top: 120px; left: 0;">
        <form onsubmit="submitRegister(event)">
            <input type="text" id="regUsername" class="bgnx-input" placeholder="Username (အမည်)" required>
            <input type="email" id="regEmail" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required>
            <input type="password" id="regPassword" class="bgnx-input" placeholder="Password (စကားဝှက်)" required>
            
            <button type="submit" class="bgnx-btn">Sign Up (စာရင်းသွင်းမည်)</button>
            
            <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
                Already have an account? <a href="#" onclick="toggleAuthForms(event, 'login')" style="color: white; font-weight: bold;">Sign In</a>
            </p>
        </form>
    </div>
</div>

<script>
    // Pure JS UI Toggle for the Auth Forms
    function toggleAuthForms(e, target) {
        e.preventDefault();
        if (target === 'register') {
            document.getElementById('loginFormContainer').style.transform = 'translateX(-120%)';
            document.getElementById('registerFormContainer').style.transform = 'translateX(0)';
        } else {
            document.getElementById('registerFormContainer').style.transform = 'translateX(120%)';
            document.getElementById('loginFormContainer').style.transform = 'translateX(0)';
        }
    }

    // Bulletproof Login Submission Handler
    function submitLogin(e) {
        e.preventDefault(); // Prevent page reload on Enter
        const email = document.getElementById('email').value;
        const pass = document.getElementById('password').value;
        
        // Ensure the app logic exists before calling
        if (typeof BaganixApp !== 'undefined') {
            BaganixApp.login(email, pass);
        } else {
            alert("App engine is still loading or missing app.js. Please wait a moment.");
        }
    }

    // Bulletproof Register Submission Handler
    function submitRegister(e) {
        e.preventDefault(); // Prevent page reload on Enter
        const username = document.getElementById('regUsername').value;
        const email = document.getElementById('regEmail').value;
        const pass = document.getElementById('regPassword').value;
        
        if (typeof BaganixApp !== 'undefined') {
            BaganixApp.register(username, email, pass);
        } else {
            alert("App engine is still loading or missing app.js. Please wait a moment.");
        }
    }
</script>