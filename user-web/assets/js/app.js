/**
 * 🌟 Baganix Core App Logic
 * Handles API communication with api.Baganix.online
 */

const API_BASE = "http://api.baganix.online/v1"; // Update to HTTPS in production

const BaganixApp = {
    // Premium UI Notification
    notify(message, type = 'info') {
        // Here we would trigger a beautiful custom dynamic-island popup
        console.log(`[Baganix ${type.toUpperCase()}] ${message}`);
        // Fallback for testing:
        alert(message);
    },

    // Handle Login
    async login(email, password) {
        try {
            const res = await fetch(`${API_BASE}/auth.php?action=login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            const data = await res.json();
            
            if (data.status === 'success') {
                localStorage.setItem('bgnx_token', data.token);
                localStorage.setItem('bgnx_user', JSON.stringify(data.user));
                
                // Change Aurora Background to user's Aura preference
                if(data.user.aura_colors) {
                    this.updateAura(data.user.aura_colors);
                }
                
                window.location.href = '?page=feed';
            } else {
                this.notify(data.message, 'error');
            }
        } catch (e) {
            this.notify("API Connection Error", 'error');
        }
    },

    // Change the Aurora background colors based on user profile
    updateAura(hexString) {
        const colors = hexString.split(',');
        if(colors.length === 2) {
            document.documentElement.style.setProperty('--color-1', colors[0]);
            document.documentElement.style.setProperty('--color-2', colors[1]);
        }
    }
};

// Bind UI Elements if on Login Page
document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById('loginBtn');
    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const pass = document.getElementById('password').value;
            BaganixApp.login(email, pass);
        });
    }
});