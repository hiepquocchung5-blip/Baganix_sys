/**
 * 🌟 Baganix Core App Logic
 * Fully Merged: Auth, Feed, and E2EE Chat Vault
 */

const API_BASE = "http://api.baganix.online/v1"; 

const BaganixApp = {
    // --- 1. UTILITIES ---
    notify(message, type = 'info') {
        Swal.fire({
            icon: type,
            title: type === 'error' ? 'Oops...' : (type === 'success' ? 'Success!' : 'Notice'),
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: 'rgba(20, 20, 30, 0.9)',
            color: '#fff'
        });
    },

    updateAura(hexString) {
        const colors = hexString.split(',');
        if(colors.length === 2) {
            document.documentElement.style.setProperty('--color-1', colors[0]);
            document.documentElement.style.setProperty('--color-2', colors[1]);
        }
    },

    // --- 2. AUTHENTICATION ---
    async login(email, password) {
        try {
            Swal.fire({ title: 'Authenticating...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

            const res = await fetch(`${API_BASE}/auth.php?action=login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            const data = await res.json();
            
            if (data.status === 'success') {
                localStorage.setItem('bgnx_token', data.token);
                localStorage.setItem('bgnx_user', JSON.stringify(data.user));
                
                if(data.user.aura_colors) this.updateAura(data.user.aura_colors);
                
                Swal.close();
                window.location.href = '?page=feed';
            } else {
                this.notify(data.message, 'error');
            }
        } catch (e) {
            this.notify("API Connection Error.", 'error');
        }
    },

    async register(username, email, password) {
        try {
            Swal.fire({ title: 'Generating E2EE Vault...', html: 'Creating your unique encryption keys.', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
            
            const publicKey = await BaganixCrypto.generateKeyPair();

            const res = await fetch(`${API_BASE}/auth.php?action=register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, email, password, public_key: publicKey })
            });
            
            const data = await res.json();
            
            if (data.status === 'success') {
                Swal.close();
                this.notify("Registration successful! You can now log in.", 'success');
                toggleAuthForms(new Event('click'), 'login'); // Switch UI to login
            } else {
                this.notify(data.message, 'error');
            }
        } catch (e) {
            this.notify("Registration Error: " + e.message, 'error');
        }
    },

    logout() {
        localStorage.removeItem('bgnx_token');
        localStorage.removeItem('bgnx_user');
        localStorage.removeItem('bgnx_private_key'); 
        window.location.href = '?page=login';
    },

    // --- 3. MAIN FEED (ZAT-LAN) ---
    async loadFeed() {
        const feedContainer = document.getElementById('feedContainer');
        if (!feedContainer) return;

        try {
            const res = await fetch(`${API_BASE}/posts.php?limit=50`);
            const data = await res.json();
            
            if (data.status === 'success') {
                feedContainer.innerHTML = ''; 
                
                if (data.data.length === 0) {
                    feedContainer.innerHTML = `<div style="text-align:center; padding: 40px 0; color: var(--text-muted);"><i class="fa-solid fa-ghost fa-3x animate__animated animate__float" style="margin-bottom: 15px; opacity: 0.5;"></i><p>No posts yet. Be the first to share your vibe!</p></div>`;
                    return;
                }

                data.data.forEach(post => {
                    const aura = post.aura_colors ? post.aura_colors.split(',') : ['#1E90FF', '#FF69B4'];
                    const dateObj = new Date(post.created_at);
                    
                    const postHTML = `
                        <div class="post-card animate__animated animate__fadeInUp" style="background: var(--glass-bg); padding: 15px; border-radius: 16px; margin-bottom: 15px; border: 1px solid var(--glass-border); position: relative; overflow: hidden;">
                            <div style="position: absolute; top:0; left:0; width: 4px; height: 100%; background: linear-gradient(to bottom, ${aura[0]}, ${aura[1]});"></div>
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, ${aura[0]}, ${aura[1]}); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                                    ${post.username.charAt(0).toUpperCase()}
                                </div>
                                <div style="margin-left: 12px;">
                                    <div style="font-weight: 600; font-size: 16px;">${post.username}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">${dateObj.toLocaleDateString()}</div>
                                </div>
                            </div>
                            <div style="font-size: 15px; line-height: 1.6; margin-bottom: 15px; white-space: pre-wrap;">${post.content}</div>
                        </div>
                    `;
                    feedContainer.innerHTML += postHTML;
                });
            }
        } catch (e) {
            this.notify("Failed to load feed.", "error");
        }
    },

    async createPost(content) {
        const userStr = localStorage.getItem('bgnx_user');
        if (!userStr) return this.notify("Please log in first.", "error");
        const user = JSON.parse(userStr);
        
        try {
            Swal.fire({ title: 'Publishing...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
            
            const res = await fetch(`${API_BASE}/posts.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: user.id, content: content, post_type: 'text' })
            });
            
            const data = await res.json();
            
            if (data.status === 'success') {
                Swal.close();
                document.getElementById('postContent').value = '';
                this.notify("Post published! 🚀", "success");
                this.loadFeed();
            } else {
                this.notify(data.message, "error");
            }
        } catch (e) {
            this.notify("Failed to publish post.", "error");
        }
    },

    // --- 4. E2EE CHAT VAULT ---
    activeChatUser: null,

    async loadContacts() {
        const contactsList = document.getElementById('contactsList');
        if (!contactsList) return;

        const userStr = localStorage.getItem('bgnx_user');
        if (!userStr) return;
        const currentUser = JSON.parse(userStr);

        try {
            const res = await fetch(`${API_BASE}/users.php?current_user_id=${currentUser.id}`);
            const data = await res.json();

            if (data.status === 'success') {
                contactsList.innerHTML = '';
                
                if (data.data.length === 0) {
                    contactsList.innerHTML = `<div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 13px;">No contacts found in Vault.</div>`;
                    return;
                }

                data.data.forEach(contact => {
                    const aura = contact.aura_colors ? contact.aura_colors.split(',') : ['#1E90FF', '#FF69B4'];
                    const contactHTML = `
                        <div class="contact-item" onclick='BaganixApp.openChat(${JSON.stringify(contact).replace(/'/g, "&apos;")})' style="display: flex; align-items: center; padding: 12px; border-radius: 12px; cursor: pointer; transition: background 0.2s; background: rgba(255,255,255,0.05); margin-bottom: 8px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, ${aura[0]}, ${aura[1]}); display: flex; justify-content: center; align-items: center; font-weight: bold;">
                                ${contact.username.charAt(0).toUpperCase()}
                            </div>
                            <div style="margin-left: 12px; flex: 1;">
                                <div style="font-weight: 600; font-size: 15px;">${contact.username}</div>
                                <div style="font-size: 12px; color: ${contact.public_key ? '#00ff88' : 'var(--text-muted)'};">
                                    ${contact.public_key ? '<i class="fa-solid fa-lock"></i> Key Secured' : 'No Public Key'}
                                </div>
                            </div>
                        </div>
                    `;
                    contactsList.innerHTML += contactHTML;
                });
            }
        } catch (e) {
            this.notify("Failed to load secure contacts.", "error");
        }
    },

    openChat(contact) {
        this.activeChatUser = contact;
        
        const nameEl = document.getElementById('chatHeaderName');
        const statusEl = document.getElementById('chatHeaderStatus');
        const letterEl = document.getElementById('chatHeaderLetter');

        if(nameEl) nameEl.innerText = contact.username;
        if(statusEl) {
            statusEl.innerHTML = contact.public_key ? '<i class="fa-solid fa-shield-halved"></i> E2EE Ready' : 'Insecure Connection';
            statusEl.style.color = contact.public_key ? '#00ff88' : '#ff5555';
        }
        if(letterEl) letterEl.innerText = contact.username.charAt(0).toUpperCase();
        
        const messagesArea = document.getElementById('messagesArea');
        if(messagesArea) messagesArea.innerHTML = `<div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 13px;">Secure connection established with ${contact.username}.</div>`;
        
        this.syncMessages();
    },

    async sendEncryptedMessage() {
        if (!this.activeChatUser) return this.notify("Select a contact first.", "warning");
        if (!this.activeChatUser.public_key) return this.notify("User has no public key. Cannot encrypt.", "error");

        const inputEl = document.getElementById('chatInput');
        const text = inputEl.value.trim();
        if (!text) return;

        const currentUser = JSON.parse(localStorage.getItem('bgnx_user'));

        try {
            this.appendMessageToUI(text, true);
            inputEl.value = '';

            const encryptedPayload = await BaganixCrypto.encryptMessage(text, this.activeChatUser.public_key);

            const res = await fetch(`${API_BASE}/chat_sync.php?action=send`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    sender_id: currentUser.id,
                    receiver_id: this.activeChatUser.id,
                    encrypted_payload: encryptedPayload
                })
            });

            const data = await res.json();
            if (data.status !== 'success') this.notify("Failed to route encrypted message.", "error");
        } catch (e) {
            this.notify("Encryption failed. " + e.message, "error");
        }
    },

    async syncMessages() {
        const currentUser = JSON.parse(localStorage.getItem('bgnx_user'));
        if (!currentUser) return;

        try {
            const res = await fetch(`${API_BASE}/chat_sync.php?action=sync&user_id=${currentUser.id}`);
            const data = await res.json();

            if (data.status === 'success' && data.payloads.length > 0) {
                for (const msg of data.payloads) {
                    try {
                        const decryptedText = await BaganixCrypto.decryptMessage(msg.encrypted_payload);
                        
                        if (this.activeChatUser && msg.sender_id == this.activeChatUser.id) {
                            this.appendMessageToUI(decryptedText, false);
                        } else {
                            this.notify("New encrypted message received!", "info");
                        }
                    } catch (decryptionError) {
                        console.error("Failed to decrypt hash.");
                    }
                }
            }
        } catch (e) {
            console.error("Vault sync error.");
        }
    },

    appendMessageToUI(text, isSentByMe) {
        const messagesArea = document.getElementById('messagesArea');
        if (!messagesArea) return;

        const bubbleHTML = `
            <div style="align-self: ${isSentByMe ? 'flex-end' : 'flex-start'}; max-width: 75%; background: ${isSentByMe ? 'linear-gradient(135deg, var(--color-1), var(--color-2))' : 'rgba(255,255,255,0.1)'}; padding: 12px 16px; border-radius: 16px; border-bottom-${isSentByMe ? 'right' : 'left'}-radius: 4px; color: white; font-size: 14px; line-height: 1.5; box-shadow: 0 4px 15px rgba(0,0,0,0.2); margin-top: 10px;">
                ${isSentByMe ? '' : '<i class="fa-solid fa-lock" style="font-size: 10px; margin-right: 5px; opacity: 0.5;"></i>'} 
                ${text.replace(/</g, "&lt;").replace(/>/g, "&gt;")}
            </div>
        `;
        messagesArea.innerHTML += bubbleHTML;
        messagesArea.scrollTop = messagesArea.scrollHeight; 
    }
};

// --- INITIALIZATION ON LOAD ---
document.addEventListener("DOMContentLoaded", () => {
    const userStr = localStorage.getItem('bgnx_user');
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || 'login';

    if (currentPage !== 'login' && !userStr) {
        window.location.href = '?page=login'; 
        return;
    }
    
    if (currentPage === 'login' && userStr) {
        window.location.href = '?page=feed'; 
        return;
    }

    if (userStr && currentPage !== 'login') {
        const user = JSON.parse(userStr);
        if(user.aura_colors) BaganixApp.updateAura(user.aura_colors);
    }

    // Init Feed
    if (document.getElementById('feedContainer')) {
        BaganixApp.loadFeed();
        const postBtn = document.getElementById('postBtn');
        if (postBtn) {
            postBtn.addEventListener('click', () => {
                const content = document.getElementById('postContent').value;
                if (!content.trim()) return BaganixApp.notify("Write something first!", "warning");
                BaganixApp.createPost(content);
            });
        }
    }

    // Init Chat Vault
    if (document.getElementById('contactsList')) {
        BaganixApp.loadContacts();
        
        // Auto-sync messages every 5 seconds
        setInterval(() => {
            BaganixApp.syncMessages();
        }, 5000);
    }
});