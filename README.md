# STUDIA

**STUDIA** adalah aplikasi web inovatif berbasis **MVC Pattern (PHP Native)** yang dirancang khusus untuk memfasilitasi *Mentorship* dan *Pertukaran Keterampilan* antar siswa. Proyek ini dibangun dengan antarmuka **Zenith Design** (Premium UI/UX) menggunakan murni HTML & CSS Vanilla (tanpa framework CSS) untuk memastikan performa yang ringan dan kustomisasi penuh.

*"Saya cinta STUDIA, ucap kata orang yang cinta pelajaran sekolah"*

**Dibangun oleh Collaborator KELOMPOK 1 TKJ 2:**
- Charles Marselino (Full-Stack (UI/UX, Front-end, Back-end))
- Harry Vannnesa(Back-end)
- Selvin Agustino (Front-end)
- Fernandez Carrick(UI/UX)

---

## 🏗️ Arsitektur Sistem (MVC)

Aplikasi ini dibangun menggunakan arsitektur **Model-View-Controller (MVC)** dari nol (buatan sendiri tanpa framework seperti Laravel/CodeIgniter):
- **Model:** Berinteraksi langsung dengan database (menggunakan PDO) untuk CRUD data (`User_model`, `Student_model`, `Mentor_model`, `Exchange_model`, dll).
- **View:** Bertanggung jawab atas UI. Disusun dalam direktori `/app/views/` dan menggunakan template system (`header.php`, `footer.php`).
- **Controller:** Mengatur flow aplikasi, menerima request user, memanggil Model, dan me-render View yang sesuai (`Auth.php`, `Student.php`, `Admin.php`, dll).
- **Core:** Berisi class esensial pembentuk kerangka aplikasi seperti `App.php` (Router), `Controller.php` (Base Controller), `Database.php` (DB Wrapper), dan `Flasher.php` (Flash Message).

---

## ✨ Fitur Utama

Aplikasi ini dibagi menjadi tiga tingkatan pengguna utama:

1. **Dashboard Siswa (Student)**
   - Mengikuti Kuesioner Minat & Bakat.
   - Pendaftaran sesi bimbingan (Gacha Mentor berdasarkan keahlian).
   - **Skill Exchange:** Menawarkan keterampilan sendiri, menjelajahi keterampilan siswa lain, dan melakukan *request pertukaran*.
   - Chat langsung (Real-time DB polling) dengan mentor.

2. **Dashboard Mentor**
   - Melihat dan menyetujui/menolak permintaan bimbingan dari siswa.
   - Fitur Live Chat dengan siswa yang dibimbing.

3. **Dashboard Admin**
   - Panel persetujuan (Approve/Reject) untuk registrasi mentor baru.
   - Manajemen data global.

---

## 🛠️ Panduan Instalasi (Installation)

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer lokal kamu (harus ada instalasi PHP dan MySQL seperti Laragon/XAMPP).

### 1. Clone Repository
```bash
git clone https://github.com/harryvanessa/PWL_STS_SAS_KELOMPOK1_XITKJ2.git STS_Kel1
cd STS_Kel1
```

### 2. Persiapan Database
1. Buka tools database (seperti **phpMyAdmin** atau HeidiSQL/DBeaver).
2. Buat database baru dengan nama `pwl_db`.
3. Import file `database.sql` yang ada di root direktori project ke dalam database `pwl_db`.

### 3. Konfigurasi Database & Base URL
Jika kamu meletakkan folder project di dalam `htdocs` atau `www` dan tidak menggunakan root domain, sistem `BASEURL` di aplikasi ini dirancang dapat menyesuaikan jalurnya otomatis.

Namun untuk mengatur kredensial database, buka file `app/config/config.php` (jika ada) atau periksa pengaturan core DB. Secara default:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pwl_db');
```

### 4. Menjalankan Aplikasi (PHP Built-in Server)
Daripada repot mengatur Apache/Nginx, cara paling efisien untuk melihat situs adalah menggunakan PHP Built-in Server. Jalankan perintah ini di dalam root folder:
```bash
php -S localhost:8000 -t public/
```
Akses di browser: `http://localhost:8000`

---

## 📖 Cara Penggunaan (Usage)

### Login Default
Saat aplikasi pertama kali dijalankan dari database bawaan (`database.sql`), kamu bisa menggunakan akun berikut:
- **Akun Admin:** `admin` / Password: `password`

### Mendaftar Sebagai Siswa
1. Akses halaman utama, klik tombol **Daftar Siswa**.
2. Isi formulir yang ada. User bisa langsung login.
3. Di dashboard, siswa dapat mengikuti *Kuesioner* atau langsung masuk ke menu *Skill Exchange*.

### Mendaftar Sebagai Mentor
1. Akses form pendaftaran dan pilih role MENTOR.
2. Akun tidak akan langsung aktif. Mentor akan mendapat status `pending`.
3. Login sebagai Admin untuk mengubah status pendaftaran mentor menjadi `Aktif`.

### Kustomisasi Konten Halaman Depan
Teks hero, deskripsi, warna *brand*, dan icon di Home Page bersifat dinamis! Untuk mengubahnya secara mudah tanpa harus masuk ke banyak view, cukup edit file konfigurasi data terpusat:
👉 `app/config/home_data.php`

---

## 🤝 Panduan Kontribusi (Contributing)

Kami terbuka untuk kontribusi pengembangan! Jika kamu ingin mengajukan *pull request*, mohon perhatikan standarisasi kode berikut:
1. **DILARANG menggunakan framework CSS (Tailwind, Bootstrap, dll).** Seluruh styling harus dilakukan di file `public/css/style.css`.
2. Model baru yang dibuat harus meng-extend class `Database` atau menggunakan helper bawaan seperti `$this->db->run()` untuk menjaga keringnya kode.
3. Jangan pernah modifikasi `index.php` di dalam root; semua *bootstrapping* ada di `/public/index.php`.

Flow Kontribusi Standar:
1. Fork repository ini.
2. Buat branch fitur (`git checkout -b fitur/NamaFiturKamu`).
3. Commit perubahanmu (`git commit -m 'Menambahkan fitur XYZ'`).
4. Push ke branch (`git push origin fitur/NamaFiturKamu`).
5. Buat Pull Request!

---

## 📜 Lisensi (MIT License)
Source code nya free, terserah dah mau di apakan