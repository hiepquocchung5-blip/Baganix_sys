<!-- 
  🌟 Baganix Main Feed (Zat-Lan)
  File: user-web/pages/feed.php
  Note: This page is loaded when '?page=feed' is in the URL.
-->
<div class="feed-wrapper" style="height: 100%; display: flex; flex-direction: column;">
    
    <!-- Top App Bar -->
    <header style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; border-bottom: 1px solid var(--glass-border); margin-bottom: 20px;">
        <h2 style="font-weight: 700; letter-spacing: -0.5px;">Baganix Feed</h2>
        <div class="header-actions">
            <!-- Navigate to E2EE Chat -->
            <button onclick="window.location.href='?page=chat'" class="bgnx-btn" style="padding: 8px 15px; width: auto; font-size: 14px;">Chat Vault 🔒</button>
        </div>
    </header>

    <!-- New Post Creator -->
    <div class="post-creator" style="background: rgba(0,0,0,0.2); padding: 15px; border-radius: 16px; margin-bottom: 20px;">
        <textarea id="postContent" class="bgnx-input" style="height: 60px; resize: none; margin-bottom: 10px;" placeholder="What's your vibe today? (ဘာတွေတွေးနေလဲ?)"></textarea>
        <div style="display: flex; justify-content: space-between;">
            <button class="bgnx-btn" style="width: 48%; background: rgba(255,255,255,0.1); padding: 10px; border: 1px dashed var(--glass-border);">📷 Media</button>
            <button id="postBtn" class="bgnx-btn" style="width: 48%; padding: 10px;">Publish 🚀</button>
        </div>
    </div>

    <!-- The Daily Deck (Feed Feed Container) -->
    <div id="feedContainer" style="flex: 1; overflow-y: auto; padding-right: 5px;">
        <!-- Premium Skeleton Loader (Shown while API fetches data) -->
        <div class="post-card" style="background: var(--glass-bg); padding: 15px; border-radius: 16px; margin-bottom: 15px; border: 1px solid var(--glass-border);">
            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); animation: pulse 1.5s infinite;"></div>
                <div style="margin-left: 12px;">
                    <div style="width: 120px; height: 14px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 8px; animation: pulse 1.5s infinite;"></div>
                    <div style="width: 70px; height: 10px; background: rgba(255,255,255,0.1); border-radius: 4px; animation: pulse 1.5s infinite;"></div>
                </div>
            </div>
            <div style="width: 100%; height: 80px; background: rgba(255,255,255,0.1); border-radius: 8px; animation: pulse 1.5s infinite;"></div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 0.3; }
        100% { opacity: 0.6; }
    }
    /* Custom thin scrollbar for the feed */
    #feedContainer::-webkit-scrollbar { width: 4px; }
    #feedContainer::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
</style>