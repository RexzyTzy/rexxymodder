# MonetLoader - Railway.com Version

## Deploy ke Railway.com

### 1. Buat Project Baru
- Login ke [railway.app](https://railway.app)
- Klik "New Project" → "Deploy from GitHub repo"
- Connect repository Anda

### 2. Tambah MySQL Database
- Di dashboard project, klik "New" → "Database" → "Add MySQL"
- Railway akan otomatis generate environment variables

### 3. Environment Variables (Otomatis dari Railway)
Railway akan otomatis set:
- `MYSQLHOST`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `MYSQLDATABASE`
- `MYSQL_URL`
- `PORT` (otomatis)

### 4. Deploy
- Klik "Deploy" dan tunggu build selesai
- Railway akan otomatis detect Nixpacks dan build PHP

### 5. Akses Website
- Domain akan otomatis dibuat: `https://your-project.up.railway.app`
- Register admin di: `/admin/regis.php`
- Login admin di: `/admin/adm.php`

### Password Website
- Password: **RexxyGacor** (sudah di-hash)

### Database
- Host: 51.83.49.125:3306
- Database: s174775_rexxy
