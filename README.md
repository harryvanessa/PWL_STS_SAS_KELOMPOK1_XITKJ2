# STUDIA - Aplikasi Mentorship

Saya cinta STUDIA, ucap kata orang yang cinta pelajarang sekolah

## Collaborator KELOMPOK 1 TKJ 2
- Charles Marselino
- Harry Vannnesa
- Selvin Agustino
- Fernandez Carrick

## Cara RUN Project

### 1. Persiapan Database
1. Buka **phpMyAdmin**.
2. Buat database baru dengan nama `pwl_db`.
3. Import file `database.sql` yang ada di root project ke dalam database `pwl_db`.

### 2. Konfigurasi Project
1. Buka file `app/config/config.php`.
2. Sesuaikan `BASEURL` dengan path project kamu. Contoh (Laragon):
   ```php
   define('BASEURL', 'http://localhost/PWL_STS_SAS_KELOMPOK1_XITKJ2/public');
   ```
3. Pastikan konfigurasi database sudah benar:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'pwl_db');
   ```

### 3. Jalankan Aplikasi
1. Buka browser dan akses URL `BASEURL` yang sudah kamu set tadi.
2. Login Admin Default:
   - **Username:** `admin`
   - **Password:** `password`

## 🛠️ Cara Kustomisasi Halaman Home (STUDIA Only)
Kamu bisa mengubah teks, icon, warna, dan data lainnya di halaman home melalui file:
`app/config/home_data.php`

---
*Di buat oleh kelompok 1*