<?php
/**
 * 🌟 Baganix Admin Users Management
 * File: admin/pages/users.php
 */

// Handle User Deletion (Ban/Wipe)
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    // In a real million-dollar app, you might use soft deletes. 
    // For now, we perform a hard wipe. (Cascades to posts & chats due to DB schema)
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ?page=users&msg=deleted");
    exit;
}

// Fetch all registered users
$usersQuery = $db->query("SELECT id, username, email, public_key, aura_colors, created_at FROM users ORDER BY created_at DESC");
?>

<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-logo">
        Baganix <span style="color: var(--accent); font-size: 12px; vertical-align: top;">ADMIN</span>
    </div>
    <a href="?page=dashboard" class="nav-item"><i class="fa-solid fa-chart-line"></i> Live Pulse</a>
    <a href="?page=users" class="nav-item active"><i class="fa-solid fa-users"></i> Users</a>
    <a href="?page=moderation" class="nav-item"><i class="fa-solid fa-shield-halved"></i> Moderation</a>
    
    <div style="margin-top: auto; padding: 20px;">
        <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 10px;">Logged in as <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></div>
        <a href="?action=logout" class="admin-btn" style="text-align: center; display: block; text-decoration: none; background: rgba(255, 50, 50, 0.1); color: #ff5555;">Logout</a>
    </div>
</aside>

<!-- Main Users Content -->
<main class="main-content">
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 600;">User Registry</h1>
            <p style="color: var(--text-muted); font-size: 14px;">Manage all ecosystem citizens and view their vault status.</p>
        </div>
        <div>
            <button class="admin-btn" style="padding: 10px 20px; font-size: 14px; width: auto;"><i class="fa-solid fa-plus"></i> Invite User</button>
        </div>
    </header>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div style="background: rgba(0, 255, 136, 0.1); border: 1px solid var(--accent); color: var(--accent); padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
            <i class="fa-solid fa-check"></i> User and associated data securely wiped.
        </div>
    <?php endif; ?>

    <!-- Data Table -->
    <div style="background: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(0,0,0,0.2); border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase;">ID / User</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase;">Email</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase;">Aura</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase;">Vault Security</th>
                    <th style="padding: 15px 20px; color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usersQuery->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">No users found in the ecosystem.</td>
                    </tr>
                <?php else: ?>
                    <?php while ($user = $usersQuery->fetch_assoc()): ?>
                        <?php 
                            $aura = explode(',', $user['aura_colors'] ?? '#1E90FF,#FF69B4');
                            $hasKey = !empty($user['public_key']);
                        ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.02); transition: 0.2s;">
                            <td style="padding: 15px 20px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, <?= $aura[0] ?>, <?= $aura[1] ?? $aura[0] ?>); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;"><?= htmlspecialchars($user['username']) ?></div>
                                        <div style="font-size: 11px; color: var(--text-muted);">ID: #<?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px 20px; color: rgba(255,255,255,0.8); font-size: 14px;">
                                <?= htmlspecialchars($user['email']) ?>
                            </td>
                            <td style="padding: 15px 20px;">
                                <div style="display: flex; gap: 5px;">
                                    <span style="width: 15px; height: 15px; border-radius: 50%; background: <?= $aura[0] ?>; display: inline-block;"></span>
                                    <span style="width: 15px; height: 15px; border-radius: 50%; background: <?= $aura[1] ?? $aura[0] ?>; display: inline-block;"></span>
                                </div>
                            </td>
                            <td style="padding: 15px 20px;">
                                <?php if ($hasKey): ?>
                                    <span style="background: rgba(0, 255, 136, 0.1); color: var(--accent); padding: 5px 10px; border-radius: 12px; font-size: 11px; border: 1px solid var(--accent-glow);">
                                        <i class="fa-solid fa-lock"></i> Secured
                                    </span>
                                <?php else: ?>
                                    <span style="background: rgba(255, 85, 85, 0.1); color: #ff5555; padding: 5px 10px; border-radius: 12px; font-size: 11px; border: 1px solid rgba(255, 85, 85, 0.3);">
                                        <i class="fa-solid fa-triangle-exclamation"></i> No Key
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px 20px; text-align: right;">
                                <a href="#" class="admin-btn" style="padding: 6px 12px; font-size: 12px; background: rgba(255,255,255,0.1); color: white; margin-right: 5px; text-decoration: none;"><i class="fa-solid fa-pen"></i></a>
                                <a href="?page=users&delete_id=<?= $user['id'] ?>" onclick="return confirm('WARNING: Are you sure you want to wipe this user? This will delete all their posts and encrypted chats.');" class="admin-btn" style="padding: 6px 12px; font-size: 12px; background: rgba(255, 85, 85, 0.1); color: #ff5555; text-decoration: none; border: 1px solid rgba(255, 85, 85, 0.3);"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>