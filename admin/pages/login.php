<?php
/**
 * 🌟 Baganix Admin Login
 * File: admin/pages/login.php
 */

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Security Note: For a true admin panel, you should add an `is_admin` BOOLEAN column to your `users` table.
    // For this prototype, we will check against the database and an arbitrary "admin flag" or hardcoded superadmin email.
    
    $stmt = $db->prepare("SELECT id, username, password_hash FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        if (password_verify($password, $admin['password_hash'])) {
            // Check if this user is actually an admin (Hardcoded for demo: change to your actual email)
            if ($email === 'admin@baganix.online' || $email === 'root@baganix.online') {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                header("Location: ?page=dashboard");
                exit;
            } else {
                $error = 'Access Denied: You do not have administrator privileges.';
            }
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'Admin account not found.';
    }
}
?>

<div class="admin-auth-wrapper">
    <div class="admin-login-box">
        <h2 style="margin-bottom: 5px; color: var(--accent);">Command Center</h2>
        <p style="color: var(--text-muted); margin-bottom: 25px; font-size: 14px;">Secure MyPanel Access</p>
        
        <?php if ($error): ?>
            <div style="background: rgba(255, 50, 50, 0.1); border: 1px solid rgba(255, 50, 50, 0.3); color: #ff5555; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px;">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?page=login">
            <input type="email" name="email" class="admin-input" placeholder="Admin Email" required>
            <input type="password" name="password" class="admin-input" placeholder="Secure Password" required>
            <button type="submit" class="admin-btn">Authenticate &lt;/&gt;</button>
        </form>
    </div>
</div>