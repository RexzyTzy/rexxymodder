# Share MonetLoader SAMP by Rexxy - Railway Version

## 🚀 Deploy ke Railway.com

### 1. Upload ke GitHub
```bash
git init
git add .
git commit -m "Initial commit"
git push origin main
```

### 2. Deploy di Railway
1. Login ke [railway.app](https://railway.app)
2. New Project → Deploy from GitHub repo
3. Pilih repository ini
4. Railway auto-detect PHP dan deploy

### 3. Setup Database
1. Di Railway dashboard, klik "New" → "Database" → "Add MySQL"
2. Railway akan auto-generate env vars
3. Atau gunakan database eksternal (edit config.php)

### 4. Environment Variables (jika pakai Railway MySQL)
Railway auto-set:
- `MYSQLHOST`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `MYSQLDATABASE`
- `MYSQL_URL`

### 5. Akses Website
- Domain: `https://your-project.up.railway.app`
- Password: **rexxyXnoah**
- Admin: `/admin/adm.php`

---

## 📁 Struktur File

| File | Fungsi |
|------|--------|
| `index.php` | Login page (password: rexxyXnoah) |
| `home.php` | Dashboard dengan stats |
| `file.php` | Daftar file + pagination + search + filter |
| `preview.php` | Preview gambar/video |
| `tutorial.php` | Tutorial CMD |
| `credits.php` | Credits tim |
| `request.php` | Request file baru |
| `report.php` | Report bug |
| `config.php` | Database config |
| `style.css` | Styling modern + responsive |
| `admin/` | Admin panel |
| `uploads/` | Folder upload file |

---

## 🔐 Password

| Menu | Password |
|------|----------|
| Website Utama | `rexxyXnoah` |
| Admin Panel | Register di `/admin/regis.php` |

---

## 🗄️ Database Tables

- `monetloader` - Data file
- `admin` - Data admin
- `requests` - Request dari user
- `reports` - Bug reports
- `activity_log` - Log aktivitas

---

## 📱 Fitur Responsive

- ✅ Mobile-friendly sidebar
- ✅ Touch-optimized buttons
- ✅ Flexible grid layouts
- ✅ Optimized for all screen sizes

---

**Created by Rexxy & Team** 🔥
