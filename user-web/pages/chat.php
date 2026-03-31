<!-- 
  🌟 Baganix E2EE Chat Vault
  File: user-web/pages/chat.php
  Note: Accessed via ?page=chat
-->
<div class="chat-wrapper" style="height: 100%; display: flex; flex-direction: column;">
    
    <!-- Top App Bar -->
    <header style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; border-bottom: 1px solid var(--glass-border); margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <button onclick="window.location.href='?page=feed'" class="bgnx-btn" style="padding: 8px 12px; width: auto; font-size: 14px; background: rgba(255,255,255,0.05); border: none;">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h2 style="font-weight: 700; letter-spacing: -0.5px;">Secure Vault <i class="fa-solid fa-shield-halved" style="color: #00ff88; font-size: 18px;"></i></h2>
        </div>
        <div class="header-actions">
            <span style="font-size: 12px; color: #00ff88; background: rgba(0, 255, 136, 0.1); padding: 5px 10px; border-radius: 12px; border: 1px solid rgba(0, 255, 136, 0.3);">E2EE Active</span>
        </div>
    </header>

    <!-- Chat Layout Container -->
    <div style="display: flex; flex: 1; overflow: hidden; gap: 20px;">
        
        <!-- Left: Contacts Sidebar -->
        <div style="width: 35%; background: rgba(0,0,0,0.2); border-radius: 16px; border: 1px solid var(--glass-border); display: flex; flex-direction: column; overflow: hidden;">
            <div style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <input type="text" class="bgnx-input" style="margin-bottom: 0; padding: 10px 15px; background: rgba(255,255,255,0.05);" placeholder="Search Vault...">
            </div>
            
            <div id="contactsList" style="flex: 1; overflow-y: auto; padding: 10px;">
                <!-- Dummy Contact Example (Will be populated by JS later) -->
                <div class="contact-item" style="display: flex; align-items: center; padding: 12px; border-radius: 12px; cursor: pointer; transition: background 0.2s; background: rgba(255,255,255,0.05); margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #1E90FF, #FF69B4); display: flex; justify-content: center; align-items: center; font-weight: bold;">
                        A
                    </div>
                    <div style="margin-left: 12px; flex: 1;">
                        <div style="font-weight: 600; font-size: 15px;">Aung Aung</div>
                        <div style="font-size: 12px; color: var(--text-muted); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">Encrypted hash received...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Active Chat Window -->
        <div style="flex: 1; background: var(--glass-bg); border-radius: 16px; border: 1px solid var(--glass-border); display: flex; flex-direction: column; position: relative;">
            
            <!-- Chat Header -->
            <div style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; backdrop-filter: blur(10px);">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #1E90FF, #FF69B4); display: flex; justify-content: center; align-items: center; font-weight: bold; margin-right: 12px;">A</div>
                <div>
                    <div style="font-weight: 600;">Aung Aung</div>
                    <div style="font-size: 11px; color: #00ff88;">Keys Verified</div>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="messagesArea" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px;">
                <!-- Skeleton Loader for Messages -->
                <div style="align-self: flex-start; max-width: 70%; background: rgba(255,255,255,0.1); padding: 12px 16px; border-radius: 16px; border-bottom-left-radius: 4px; color: white; font-size: 14px; line-height: 1.5;">
                    <i class="fa-solid fa-lock" style="font-size: 10px; margin-right: 5px; opacity: 0.5;"></i> Decrypting secure payload...
                </div>
                
                <div style="align-self: flex-end; max-width: 70%; background: linear-gradient(135deg, var(--color-1), var(--color-2)); padding: 12px 16px; border-radius: 16px; border-bottom-right-radius: 4px; color: white; font-size: 14px; line-height: 1.5; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    Hi! This message is end-to-end encrypted. The server only sees a hash. 🔒
                </div>
            </div>

            <!-- Input Area -->
            <div style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; gap: 10px; background: rgba(0,0,0,0.2); border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                <button class="bgnx-btn" style="width: auto; padding: 10px 15px; background: rgba(255,255,255,0.05); border: none;"><i class="fa-solid fa-paperclip"></i></button>
                <input type="text" id="chatInput" class="bgnx-input" style="margin-bottom: 0; flex: 1; border-radius: 20px; padding: 10px 20px;" placeholder="Type an encrypted message (လျှို့ဝှက်စာတိုပို့ရန်)...">
                <button class="bgnx-btn" style="width: auto; padding: 10px 20px; background: white; color: black; border-radius: 20px;"><i class="fa-solid fa-paper-plane"></i></button>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar for Chat */
    #messagesArea::-webkit-scrollbar, #contactsList::-webkit-scrollbar { width: 4px; }
    #messagesArea::-webkit-scrollbar-thumb, #contactsList::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    
    .contact-item:hover { background: rgba(255,255,255,0.1) !important; transform: scale(0.98); }
</style>