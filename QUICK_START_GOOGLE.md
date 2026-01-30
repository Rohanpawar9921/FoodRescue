# 🔐 Quick Start: Google Sign-In

## 3-Step Setup

### Step 1: Get Credentials (5 minutes)
1. Visit: https://console.cloud.google.com/
2. Create project → Enable Google+ API
3. Create OAuth 2.0 Client ID
4. Add redirect URI: `http://localhost:8000/php/google-callback.php`
5. Copy **Client ID** and **Client Secret**

### Step 2: Configure (2 minutes)
Replace `YOUR_GOOGLE_CLIENT_ID_HERE` in these 3 files:
- `php/google-config.php` (lines 5-6)
- `pages/login.php` (line ~103)
- `pages/signup.php` (line ~113)

### Step 3: Update Database (1 minute)
```bash
sqlite3 mini_shop.db "ALTER TABLE users ADD COLUMN google_id TEXT; ALTER TABLE users ADD COLUMN profile_picture TEXT;"
```

## Test It
```bash
php -S 0.0.0.0:8000 -t /workspaces/Manage-Learners
```
Visit: http://localhost:8000/pages/login.php

Click **Google** button → Login → Done! ✨

---

📖 Full guide: [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)
