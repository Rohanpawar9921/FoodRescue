# Google OAuth Setup Guide

## Steps to Enable Google Sign-In

### 1. Get Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the **Google+ API**:
   - Go to "APIs & Services" → "Library"
   - Search for "Google+ API"
   - Click "Enable"

4. Create OAuth 2.0 Credentials:
   - Go to "APIs & Services" → "Credentials"
   - Click "Create Credentials" → "OAuth 2.0 Client ID"
   - If prompted, configure the OAuth consent screen first:
     - User Type: External
     - App name: Your app name
     - User support email: Your email
     - Authorized domains: (leave empty for localhost)
     - Developer contact: Your email
   
5. Configure OAuth Client:
   - Application type: Web application
   - Name: "Product Catalog Web Client"
   - **Authorized JavaScript origins**:
     - `http://localhost:8000`
     - Add your production URL later (e.g., `https://yourdomain.com`)
   - **Authorized redirect URIs**:
     - `http://localhost:8000/php/google-callback.php`
     - Add production URL later (e.g., `https://yourdomain.com/php/google-callback.php`)
   
6. Click "Create" and copy:
   - **Client ID** (ends with `.apps.googleusercontent.com`)
   - **Client Secret**

### 2. Configure Your Application

1. Edit `php/google-config.php`:
   ```php
   define('GOOGLE_CLIENT_ID', 'YOUR_CLIENT_ID_HERE.apps.googleusercontent.com');
   define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET_HERE');
   ```

2. Edit `pages/login.php` (around line 103):
   ```javascript
   const GOOGLE_CLIENT_ID = 'YOUR_CLIENT_ID_HERE.apps.googleusercontent.com';
   ```

3. Edit `pages/signup.php` (around line 113):
   ```javascript
   const GOOGLE_CLIENT_ID = 'YOUR_CLIENT_ID_HERE.apps.googleusercontent.com';
   ```

### 3. Update Database Schema

Run the schema update script to add Google OAuth columns:

```bash
cd /workspaces/Manage-Learners
sqlite3 mini_shop.db < php/update_schema_google.php
```

Or manually add columns:
```sql
ALTER TABLE users ADD COLUMN google_id TEXT DEFAULT NULL;
ALTER TABLE users ADD COLUMN profile_picture TEXT DEFAULT NULL;
CREATE INDEX idx_google_id ON users(google_id);
```

### 4. Test the Integration

1. Start your server:
   ```bash
   php -S 0.0.0.0:8000 -t /workspaces/Manage-Learners
   ```

2. Visit: `http://localhost:8000/pages/login.php`

3. Click the **Google** button

4. You should be redirected to Google's login page

5. After authentication, you'll be redirected back and automatically logged in

### 5. Security Considerations

**For Production:**

1. Use HTTPS (required by Google)
2. Update redirect URIs in both:
   - Google Cloud Console
   - `php/google-config.php`
3. Store credentials securely (environment variables)
4. Add CSRF protection
5. Implement rate limiting

### 6. Troubleshooting

**Error: "redirect_uri_mismatch"**
- Make sure the redirect URI in Google Console exactly matches your callback URL
- Check for trailing slashes
- Ensure protocol matches (http vs https)

**Error: "invalid_client"**
- Verify Client ID and Client Secret are correct
- Check that they're properly configured in both PHP and JavaScript

**Error: "access_denied"**
- User cancelled the authentication
- Check OAuth consent screen configuration

**Database Error**
- Run the schema update script
- Verify `users` table has `google_id` and `profile_picture` columns

### 7. Features Included

✅ **Login with Google** - Users can sign in using Google account
✅ **Sign Up with Google** - New users can register via Google
✅ **Profile Picture** - Automatically fetches Google profile picture
✅ **Email Verification** - Google emails are pre-verified
✅ **Auto Username** - Generates username from Google name/email
✅ **Session Management** - Maintains login state
✅ **Duplicate Prevention** - Handles existing users linking Google accounts

### 8. How It Works

1. User clicks "Google" button
2. Redirected to Google OAuth consent screen
3. User approves access to email and profile
4. Google redirects back with authorization code
5. Server exchanges code for access token
6. Server fetches user info from Google API
7. Creates/updates user in database
8. Logs user in with session

### 9. Next Steps (Optional)

- Add GitHub OAuth similarly
- Add "Link Google Account" feature for existing users
- Show profile picture in navigation
- Add "Disconnect Google" option in settings
- Implement account merging if user signs up both ways

## File Structure

```
php/
  ├── google-config.php         # OAuth credentials
  ├── google-callback.php       # Handles OAuth callback
  └── update_schema_google.php  # Database migration

pages/
  ├── login.php                 # Updated with Google button
  └── signup.php                # Updated with Google button
```

## Support

If you encounter issues:
1. Check browser console for JavaScript errors
2. Check PHP error logs
3. Verify all credentials are correctly configured
4. Ensure redirect URIs match exactly
5. Test with a different Google account
