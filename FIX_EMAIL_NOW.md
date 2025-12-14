# 🚨 FIX EMAIL ERROR - ACTION REQUIRED

## The Problem
You're still using your regular Gmail password, but Gmail requires an **application-specific password** because 2FA is enabled.

## ✅ DO THIS NOW (3 Simple Steps)

### 1️⃣ Generate App Password (2 minutes)
**Go directly to:** https://myaccount.google.com/apppasswords

- Select **Mail** → **Other (Custom name)** → Enter "Laravel"
- Click **Generate**
- **COPY the 16-character password** (example: `abcd efgh ijkl mnop`)

### 2️⃣ Update .env File
Open: `C:\xampp\htdocs\DATN-QLMN\QLMN_BE\.env`

Find line with `MAIL_PASSWORD=` and change it to:

```env
MAIL_PASSWORD=abcdefghijklmnop
```

**Replace `abcdefghijklmnop` with YOUR 16-character password (remove spaces!)**

### 3️⃣ Clear Cache
Open terminal in your project folder and run:

```bash
php artisan config:clear
```

### 4️⃣ Test Again
Try your forgot password function again.

---

## ⚠️ Common Mistakes

❌ Using regular Gmail password  
✅ Use application-specific password  

❌ Password with spaces: `abcd efgh ijkl mnop`  
✅ Password without spaces: `abcdefghijklmnop`  

❌ Forgetting to run `php artisan config:clear`  
✅ Always clear cache after .env changes  

---

## Need Help?

Run this to check your configuration:
```bash
php artisan mail:check
```

See full guide: `GMAIL_SETUP.md`

