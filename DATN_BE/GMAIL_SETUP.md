# Gmail SMTP Configuration Guide

## ⚠️ CRITICAL ISSUE

You're getting the error: **"Application-specific password required"**

This means your Gmail account (`lauraschool.dng@gmail.com`) has 2-Factor Authentication (2FA) enabled, and you MUST use an **application-specific password** instead of your regular Gmail password.

## ✅ QUICK FIX - Follow These Steps Exactly

### Step 1: Generate Application-Specific Password

**Direct Link:** https://myaccount.google.com/apppasswords

**OR follow these steps:**

1. Go to: https://myaccount.google.com/
2. Click **Security** (left sidebar)
3. Under **How you sign in to Google**, click **2-Step Verification**
4. Scroll down to **App passwords**
5. Click **App passwords**
6. You may need to sign in again
7. At the bottom, select:
    - **App:** Mail
    - **Device:** Other (Custom name)
    - **Name:** Type "Laravel Application" or any name
8. Click **Generate**
9. **IMPORTANT:** Copy the 16-character password immediately (it looks like: `abcd efgh ijkl mnop` or `abcdefghijklmnop`)
    - ⚠️ You can only see this password ONCE!

### Step 2: Update Your .env File

Open your `.env` file (located at the root of your project: `C:\xampp\htdocs\DATN-QLMN\QLMN_BE\.env`)

Find these lines (around line 53-59) and update them:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=lauraschool.dng@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=lauraschool.dng@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**CRITICAL NOTES:**

-   Replace `abcdefghijklmnop` with your actual 16-character app password
-   **Remove ALL spaces** from the password (if it shows as `abcd efgh ijkl mnop`, use `abcdefghijklmnop`)
-   The password should be exactly 16 characters with NO spaces
-   Make sure there are NO quotes around the password value

### Step 3: Update Your .env File

Update the following environment variables in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=lauraschool.dng@gmail.com
MAIL_PASSWORD=your-16-character-app-password-here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=lauraschool.dng@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Important Notes:**

-   Use the **16-character application-specific password** (not your regular Gmail password)
-   Remove spaces from the password when pasting (it should be 16 characters without spaces)
-   Keep the application-specific password secure and don't share it

### Alternative: Using SSL (Port 465)

If port 587 doesn't work, you can use SSL with port 465:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=lauraschool.dng@gmail.com
MAIL_PASSWORD=your-16-character-app-password-here
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=lauraschool.dng@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 3: Clear Configuration Cache ⚠️ REQUIRED!

**You MUST do this after updating .env!**

Open your terminal/command prompt in your project directory and run:

```bash
php artisan config:clear
```

Or if you're using PowerShell:

```powershell
php artisan config:clear
```

### Step 4: Verify Configuration

Check your mail configuration:

```bash
php artisan mail:check
```

This will show you:

-   Your current mail settings
-   Whether your password length is correct (should be 16 characters)
-   Any configuration issues

### Step 5: Test

Try sending an email again using your forgot password functionality.

## ✅ Checklist

Before trying again, make sure:

-   [ ] You generated an application-specific password from Google
-   [ ] The password is exactly 16 characters (no spaces)
-   [ ] You updated `MAIL_PASSWORD` in `.env` file
-   [ ] You removed all spaces from the password
-   [ ] You saved the `.env` file
-   [ ] You ran `php artisan config:clear`
-   [ ] You verified with `php artisan mail:check`

## Troubleshooting

### If you still get authentication errors:

1. Double-check that you copied the entire 16-character password correctly
2. Make sure there are no extra spaces in the password
3. Verify that 2FA is enabled on your Google account
4. Try generating a new application-specific password
5. Make sure "Less secure app access" is NOT enabled (it should be disabled for better security)

### Alternative: Use Gmail OAuth2

For production environments, consider using OAuth2 authentication instead of application passwords for better security. However, this requires additional setup with Google Cloud Console.
