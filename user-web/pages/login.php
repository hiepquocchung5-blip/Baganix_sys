<!-- 
  🌟 Baganix Dynamic Login / Registration UI
  File: user-web/pages/login.php
-->
<div class="auth-wrapper animate__animated animate__zoomIn" style="text-align: center; margin-top: 20px; overflow: hidden; position: relative; min-height: 520px; padding: 20px;">
    
    <!-- Dynamic Greeting & Typewriter -->
    <h3 id="timeGreeting" style="font-size: 1.2rem; color: var(--accent); font-weight: 400; margin-bottom: 5px;">Welcome</h3>
    <h1 style="font-size: 3.5rem; margin-bottom: 5px; font-weight: 800; letter-spacing: -2px; background: linear-gradient(135deg, var(--color-1), var(--color-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Baganix</h1>
    <p id="typewriter" style="color: var(--text-muted); margin-bottom: 30px; font-size: 1.1rem; height: 25px; font-weight: 300;"></p>

    <!-- Login Form -->
    <div id="loginFormContainer" style="transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); position: absolute; width: 100%; top: 160px; left: 0; padding: 0 30px;">
        <form onsubmit="submitLogin(event)">
            <input type="email" id="email" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required style="margin-bottom: 15px;">
            
            <div style="position: relative; margin-bottom: 25px;">
                <input type="password" id="password" class="bgnx-input" placeholder="Password (စကားဝှက်)" required style="margin-bottom: 0; padding-right: 45px;">
                <i class="fa-regular fa-eye toggle-pwd" onclick="togglePassword('password', this)" style="position: absolute; right: 15px; top: 18px; color: var(--text-muted); cursor: pointer; transition: 0.3s;"></i>
            </div>
            
            <button type="submit" class="bgnx-btn" style="box-shadow: 0 8px 25px rgba(30,144,255,0.3);">Sign In <i class="fa-solid fa-arrow-right-to-bracket" style="margin-left: 5px;"></i></button>
            
            <p style="margin-top: 25px; font-size: 0.95rem; color: var(--text-muted);">
                New to Baganix? <a href="#" onclick="toggleAuthForms(event, 'register')" style="color: var(--color-1); font-weight: 600; text-decoration: none; border-bottom: 1px dashed var(--color-1);">Create an account</a>
            </p>
        </form>
    </div>

    <!-- Registration Form (Hidden initially) -->
    <div id="registerFormContainer" style="transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); transform: translateX(120%); position: absolute; width: 100%; top: 160px; left: 0; padding: 0 30px;">
        <form onsubmit="submitRegister(event)">
            <input type="text" id="regUsername" class="bgnx-input" placeholder="Username (အမည်)" required style="margin-bottom: 15px;">
            <input type="email" id="regEmail" class="bgnx-input" placeholder="Email (အီးမေးလ်)" required style="margin-bottom: 15px;">
            
            <div style="position: relative; margin-bottom: 10px;">
                <input type="password" id="regPassword" class="bgnx-input" placeholder="Secure Password (စကားဝှက်)" required onkeyup="checkPasswordStrength(this.value)" style="margin-bottom: 0; padding-right: 45px;">
                <i class="fa-regular fa-eye toggle-pwd" onclick="togglePassword('regPassword', this)" style="position: absolute; right: 15px; top: 18px; color: var(--text-muted); cursor: pointer; transition: 0.3s;"></i>
            </div>

            <!-- Dynamic Password Strength Meter -->
            <div style="display: flex; gap: 5px; margin-bottom: 25px; padding: 0 5px;">
                <div id="strength-1" style="height: 4px; flex: 1; background: rgba(255,255,255,0.1); border-radius: 2px; transition: 0.3s;"></div>
                <div id="strength-2" style="height: 4px; flex: 1; background: rgba(255,255,255,0.1); border-radius: 2px; transition: 0.3s;"></div>
                <div id="strength-3" style="height: 4px; flex: 1; background: rgba(255,255,255,0.1); border-radius: 2px; transition: 0.3s;"></div>
            </div>
            
            <button type="submit" class="bgnx-btn" style="box-shadow: 0 8px 25px rgba(255,105,180,0.3);">Initialize Vault <i class="fa-solid fa-shield-halved" style="margin-left: 5px;"></i></button>
            
            <p style="margin-top: 25px; font-size: 0.95rem; color: var(--text-muted);">
                Already have a Vault? <a href="#" onclick="toggleAuthForms(event, 'login')" style="color: var(--color-2); font-weight: 600; text-decoration: none; border-bottom: 1px dashed var(--color-2);">Sign In</a>
            </p>
        </form>
    </div>
</div>

<script>
    // --- 1. Dynamic Time-Based Greeting ---
    function setGreeting() {
        const hour = new Date().getHours();
        let greeting = "Mingalabar (မင်္ဂလာပါ)";
        if (hour < 12) greeting = "Good Morning (မင်္ဂလာနံနက်ခင်းပါ)";
        else if (hour < 18) greeting = "Good Afternoon (မင်္ဂလာနေ့လည်ခင်းပါ)";
        else greeting = "Good Evening (မင်္ဂလာညနေခင်းပါ)";
        document.getElementById('timeGreeting').innerText = greeting;
    }
    setGreeting();

    // --- 2. Typewriter Effect ---
    const phrases = ["The next generation ecosystem.", "True End-to-End Encryption.", "Share your vibe securely.", "Your personal digital vault."];
    let phraseIndex = 0;
    let letterIndex = 0;
    let isDeleting = false;
    const typewriterElement = document.getElementById('typewriter');

    function typeWriter() {
        const currentPhrase = phrases[phraseIndex];
        if (isDeleting) {
            typewriterElement.innerText = currentPhrase.substring(0, letterIndex - 1);
            letterIndex--;
        } else {
            typewriterElement.innerText = currentPhrase.substring(0, letterIndex + 1);
            letterIndex++;
        }

        let typingSpeed = isDeleting ? 50 : 100;

        if (!isDeleting && letterIndex === currentPhrase.length) {
            typingSpeed = 2000; // Pause at the end
            isDeleting = true;
        } else if (isDeleting && letterIndex === 0) {
            isDeleting = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
            typingSpeed = 500; // Pause before typing next
        }
        setTimeout(typeWriter, typingSpeed);
    }
    typeWriter();

    // --- 3. Password Show/Hide Toggle ---
    function togglePassword(inputId, iconElement) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
            iconElement.style.color = 'var(--color-1)';
        } else {
            input.type = "password";
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
            iconElement.style.color = 'var(--text-muted)';
        }
    }

    // --- 4. Password Strength Meter ---
    function checkPasswordStrength(password) {
        const s1 = document.getElementById('strength-1');
        const s2 = document.getElementById('strength-2');
        const s3 = document.getElementById('strength-3');
        
        // Reset
        s1.style.background = s2.style.background = s3.style.background = 'rgba(255,255,255,0.1)';
        
        if (password.length > 0) s1.style.background = '#ff5555'; // Weak (Red)
        if (password.length >= 6 && /[0-9]/.test(password)) {
            s1.style.background = s2.style.background = '#ffaa00'; // Medium (Orange)
        }
        if (password.length >= 8 && /[A-Z]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
            s1.style.background = s2.style.background = s3.style.background = '#00ff88'; // Strong (Green)
        }
    }

    // --- 5. UI Form Toggle ---
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

    // --- 6. Form Submission Binds ---
    function submitLogin(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const pass = document.getElementById('password').value;
        if (typeof BaganixApp !== 'undefined') BaganixApp.login(email, pass);
    }

    function submitRegister(e) {
        e.preventDefault();
        const username = document.getElementById('regUsername').value;
        const email = document.getElementById('regEmail').value;
        const pass = document.getElementById('regPassword').value;
        if (typeof BaganixApp !== 'undefined') BaganixApp.register(username, email, pass);
    }
</script>