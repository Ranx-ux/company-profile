<<<<<<< HEAD
<<<<<<< HEAD
# Company Profile - PT Jaya Makmur
Sistem Company Profile berbasis CodeIgniter 4 dengan Dashboard Admin (AdminLTE 3.2.0)

---

## Cara Instalasi

### 1. Persyaratan
- PHP >= 8.2
- MySQL / MariaDB
- Apache (XAMPP/WAMP/Laragon)
- mod_rewrite aktif

### 2. Letakkan folder
Pastikan folder `companyprofile` berada di dalam `htdocs` (XAMPP):
```
C:/xampp/htdocs/companyprofile/
```

### 3. Import Database
Buka **phpMyAdmin** → klik **Import** → pilih file:
```
companyprofile/db_company.sql
```
Database `db_companyprofile` akan otomatis dibuat.

### 4. Konfigurasi .env
Edit file `companyprofile/.env` jika perlu:
```
app.baseURL = 'http://localhost/companyprofile/public/'
database.default.hostname = localhost
database.default.database = db_companyprofile
database.default.username = root
database.default.password =        ← isi jika MySQL kamu pakai password
```

### 5. Aktifkan mod_rewrite
Di XAMPP: buka `httpd.conf`, pastikan baris ini tidak dikomentari:
```
LoadModule rewrite_module modules/mod_rewrite.so
```

### 6. Buka di browser
```
http://localhost/companyprofile/public/
```

---

## Akun Admin Default
| Field    | Value                        |
|----------|------------------------------|
| URL      | /admin/login                 |
| Email    | admin@jayamakmur.co.id       |
| Password | admin123                     |

---

## Struktur Folder
```
companyprofile/
├── app/
│   ├── Config/          → Konfigurasi CI4 (Routes, Database, dll)
│   ├── Controllers/     → Controller frontend & admin
│   │   └── Admin/       → Controller khusus admin
│   ├── Database/
│   │   ├── Migrations/  → Struktur tabel database
│   │   └── Seeds/       → Data awal database
│   ├── Filters/         → AuthFilter untuk proteksi admin
│   ├── Models/          → Model database
│   └── Views/
│       ├── admin/       → Tampilan dashboard admin (AdminLTE)
│       └── frontend/    → Tampilan website publik
├── public/
│   ├── index.php        → Entry point
│   ├── .htaccess        → URL rewriting
│   └── uploads/         → Folder upload gambar
│       ├── logo/
│       ├── services/
│       ├── gallery/
│       └── users/
├── system/              → Core CodeIgniter 4
├── writable/            → Cache, logs, session
├── .env                 → Konfigurasi environment
└── db_company.sql       → File SQL database
```

---

## Fitur Website (Frontend)
| Halaman       | URL          | Keterangan                              |
|---------------|--------------|-----------------------------------------|
| Beranda       | /            | Hero, statistik, preview layanan & galeri |
| Tentang Kami  | /about       | Profil, visi misi, nilai perusahaan     |
| Produk & Layanan | /services | Daftar layanan dengan filter kategori   |
| Galeri        | /gallery     | Foto kegiatan dengan lightbox           |
| Kontak        | /contact     | Form kontak + peta + info kontak        |

## Fitur Dashboard Admin
| Menu              | URL                  | Keterangan                    |
|-------------------|----------------------|-------------------------------|
| Dashboard         | /admin/dashboard     | Statistik & aksi cepat        |
| Profil Perusahaan | /admin/profile       | Edit nama, logo, visi, misi   |
| Produk & Layanan  | /admin/services      | CRUD layanan/produk           |
| Galeri            | /admin/gallery       | CRUD foto galeri              |
| User Admin        | /admin/users         | CRUD akun admin               |
| Logout            | /admin/logout        | Keluar dari dashboard         |
=======
# companyprofile1
>>>>>>> 38c1a0232def23981afd43ebd9faefeb39d9b866
=======
# company-profile
>>>>>>> 765dd65131a0860fc8f441373be2025afccb369c
