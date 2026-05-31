# 🚀 LOCALHOST SETUP GUIDE

## Quick Start: Access Website on localhost/admagpro

### ✅ CURRENT CONFIGURATION

**Status**: Website is configured to run on `localhost/admagpro`

**Configuration Files Updated:**
- ✅ `.env` - `APP_URL=http://localhost/admagpro`
- ✅ `vite.config.js` - Base path set to `/admagpro/`

---

## 📋 SETUP STEPS

### Step 1: Ensure XAMPP is Running
```bash
# Start XAMPP (Apache + MySQL)
# In XAMPP Control Panel:
# - Start Apache
# - Start MySQL
```

### Step 2: Verify Project Location
```bash
# Project should be at:
c:\xampp\htdocs\admagpro\

# Verify public folder exists:
c:\xampp\htdocs\admagpro\public\
```

### Step 3: Install Dependencies (if not done)
```bash
cd c:\xampp\htdocs\admagpro

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Build frontend assets
npm run build
```

### Step 4: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### Step 5: Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Step 6: Generate Storage Link
```bash
php artisan storage:link
```

---

## 🌐 ACCESS THE WEBSITE

### URLs to Access

**Customer Pages:**
- Home: http://localhost/admagpro/home/new
- Login: http://localhost/admagpro/login/new
- Register: http://localhost/admagpro/register/new
- Products: http://localhost/admagpro/products/new
- Cart: http://localhost/admagpro/cart/new
- Orders: http://localhost/admagpro/orders/new
- Wallet: http://localhost/admagpro/wallet/new

**Admin Pages:**
- Admin Dashboard: http://localhost/admagpro/admin/new

**API Endpoints:**
- API Base: http://localhost/admagpro/api/v1
- Home API: http://localhost/admagpro/api/v1/home
- Products API: http://localhost/admagpro/api/v1/products

---

## 🔧 CONFIGURATION FILES

### .env (Already Configured)
```env
APP_URL=http://localhost/admagpro
FRONTEND_URL=http://localhost/admagpro
```

### vite.config.js (Already Configured)
```javascript
base: '/admagpro/',
```

### Apache Virtual Host (Optional)
If you want to access via custom domain instead of subdirectory:

**Edit** `c:\xampp\apache\conf\extra\httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    ServerName admagpro.local
    DocumentRoot "c:\xampp\htdocs\admagpro\public"
    
    <Directory "c:\xampp\htdocs\admagpro\public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then add to `c:\windows\system32\drivers\etc\hosts`:
```
127.0.0.1  admagpro.local
```

And access via: `http://admagpro.local`

---

## ✅ VERIFICATION

### Check if Working

**Test 1: Home Page**
```
Visit: http://localhost/admagpro/home/new
Expected: Hero banner, products, categories visible
```

**Test 2: API**
```bash
curl -X GET http://localhost/admagpro/api/v1/home
Expected: JSON response with dashboard data
```

**Test 3: Static Assets**
```
Check browser console for CSS/JS loading
Expected: No 404 errors for assets
```

---

## 🐛 TROUBLESHOOTING

### Issue 1: Page Shows 404
**Solution:**
- Verify `.htaccess` exists in `public/` folder
- Check Apache mod_rewrite is enabled
- Restart Apache

### Issue 2: CSS/JS Not Loading
**Solution:**
- Run `npm run build`
- Clear browser cache (Ctrl+Shift+Delete)
- Check vite.config.js has `base: '/admagpro/'`

### Issue 3: Database Connection Error
**Solution:**
- Verify MySQL is running
- Check `.env` database credentials
- Run `php artisan migrate`

### Issue 4: Permission Denied Errors
**Solution:**
- Run as Administrator
- Check folder permissions
- Run `php artisan storage:link`

---

## 📂 PROJECT STRUCTURE

```
c:\xampp\htdocs\admagpro\
├── public/                    # Web root (served by Apache)
│   ├── index.php             # Entry point
│   ├── .htaccess             # URL rewriting rules
│   └── assets/               # Static files
├── resources/
│   ├── views/                # Blade templates
│   │   ├── home/
│   │   ├── auth/
│   │   ├── products/
│   │   ├── cart/
│   │   ├── orders/
│   │   ├── wallet/
│   │   ├── admin/
│   │   └── layouts/
│   ├── css/                  # Tailwind CSS
│   └── js/                   # JavaScript
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── routes/
│   ├── api.php              # API routes (76 endpoints)
│   └── web.php              # Web routes (customer pages)
├── config/
│   └── payment_testing.php  # Payment config
├── .env                     # Environment variables
└── vite.config.js          # Build configuration
```

---

## 🚀 START DEVELOPMENT

### Option 1: Hot Reload Development
```bash
# Terminal 1: Run development server
php artisan serve --host=localhost --port=8000

# Terminal 2: Watch for changes
npm run dev
```

Then access: http://localhost:8000

### Option 2: XAMPP with Auto-Reload
```bash
# Just run:
npm run dev

# Access:
http://localhost/admagpro
```

---

## 📊 QUICK REFERENCE

| Task | Command |
|------|---------|
| Install deps | `composer install && npm install` |
| Build assets | `npm run build` |
| Dev mode | `npm run dev` |
| Run migrations | `php artisan migrate` |
| Clear cache | `php artisan config:clear` |
| Seed data | `php artisan db:seed` |
| Storage link | `php artisan storage:link` |

---

## ✨ NEXT STEPS

1. ✅ Run `composer install`
2. ✅ Run `npm install`
3. ✅ Run `npm run build`
4. ✅ Run `php artisan migrate`
5. ✅ Visit http://localhost/admagpro/home/new

**Website is now ready on localhost/admagpro!**
