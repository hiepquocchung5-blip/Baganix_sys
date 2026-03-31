
-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    public_key TEXT NULL COMMENT 'Client-generated public key for E2EE Chat',
    bio VARCHAR(255) DEFAULT '',
    aura_colors VARCHAR(20) DEFAULT '#1E90FF,#FF69B4' COMMENT 'Hex codes for profile Aurora Glass theme',
    merit_points INT DEFAULT 0 COMMENT 'Karma/Kutho system',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Posts & Reels Table (Zat-Lan)
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    media_url VARCHAR(255) DEFAULT NULL,
    post_type ENUM('text', 'image', 'reel', 'audio') DEFAULT 'text',
    vibe_score INT DEFAULT 0 COMMENT 'Replaces traditional likes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. E2EE Chat Hashes Table
CREATE TABLE IF NOT EXISTS chat_hashes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    encrypted_payload TEXT NOT NULL COMMENT 'Encrypted message hash. PHP cannot read this.',
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Relationships (Followers/Friends)
CREATE TABLE IF NOT EXISTS relationships (
    follower_id INT NOT NULL,
    following_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (follower_id, following_id),
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;