<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Panduan Deployment Laravel 12 ke GitHub Pages

Berikut adalah panduan langkah demi langkah untuk men-deploy aplikasi Laravel 12 ke GitHub Pages menggunakan workflow yang telah saya siapkan.

## 1. Struktur Workflow

Workflow yang telah saya siapkan terdiri dari dua pekerjaan utama:

1. **laravel-tests**: Menjalankan pengujian Laravel untuk memastikan aplikasi berfungsi dengan baik
2. **deploy-gh-pages**: Men-deploy aplikasi ke GitHub Pages setelah pengujian berhasil

## 2. Persiapan Repositori

1. **Buat file workflow GitHub Actions**:

    - Buat direktori `.github/workflows/` di root repositori Anda jika belum ada
    - Buat file `laravel.yml` dalam direktori tersebut dan salin konten workflow yang telah saya berikan

2. **Pastikan struktur file yang diperlukan telah ada**:
    - File `.env.example` di root repositori
    - File `.htaccess` di folder `public/` (gunakan konten yang telah saya sediakan)

## 3. Menyesuaikan File .env untuk GitHub Pages

Penting untuk memperhatikan konfigurasi `.env` yang akan dibuat selama proses deployment. Workflow akan:

1. Menyalin `.env.example` ke `.env`
2. Mengubah nilai-nilai berikut:
    - `APP_ENV=production`
    - `APP_DEBUG=false`
    - `APP_URL=https://[username].github.io/[repo-name]`

Jika Anda memerlukan konfigurasi khusus, Anda dapat menyesuaikan bagian `Copy .env for Production` dalam workflow.

## 4. Memahami Proses Deployment ke GitHub Pages

Workflow akan:

1. Membuat direktori `gh-pages-build/`
2. Menyalin seluruh konten folder `public/` ke direktori tersebut
3. Membuat file `index.php` khusus untuk GitHub Pages
4. Membuat file `.nojekyll` untuk mencegah pemrosesan Jekyll
5. Men-deploy konten direktori ke branch `gh-pages`

## 5. Mengaktifkan GitHub Pages

Setelah workflow berhasil dijalankan:

1. Buka repositori GitHub Anda
2. Klik tab "Settings"
3. Pilih "Pages" dari menu sidebar
4. Pada bagian "Source", pilih branch "gh-pages" dan folder "/" (root)
5. Klik "Save"

Website Anda akan tersedia di URL: `https://[username].github.io/[repo-name]/`

## 6. Batasan dan Catatan Penting

GitHub Pages tidak mendukung eksekusi kode PHP secara native. Berikut adalah yang perlu Anda ketahui:

1. **Apa yang akan berfungsi**:

    - Semua aset statis (CSS, JS, gambar)
    - Frontend yang dibangun dengan Vite/Laravel Mix
    - File HTML statis

2. **Apa yang tidak akan berfungsi**:

    - Eksekusi kode PHP
    - Rute backend Laravel
    - Akses database melalui PHP

3. **Solusi untuk fungsionalitas backend**:
    - Gunakan API eksternal yang di-hosting di tempat lain
    - Integrasikan dengan layanan serverless
    - Gunakan penyedia hosting yang mendukung PHP untuk backend

## 7. Cara Membuat Aplikasi Laravel Kompatibel dengan GitHub Pages

Untuk membuat aplikasi Laravel optimal untuk GitHub Pages:

1. **Gunakan pendekatan SPA (Single Page Application)**:

    - Bangun frontend dengan Vue.js, React, atau library JS lainnya
    - Gunakan Vite/Laravel Mix untuk mengompilasi aset
    - Implementasikan routing frontend di sisi klien

2. **Pisahkan backend dan frontend**:

    - Deploy backend Laravel ke hosting PHP terpisah
    - Konsumsi API dari backend di aplikasi frontend

3. **Gunakan Static Site Generation**:
    - Pertimbangkan untuk menghasilkan halaman statis untuk konten yang tidak sering berubah
    - Gunakan fitur caching untuk meningkatkan performa

## 8. Pemecahan Masalah Umum

### Aset tidak dimuat

-   Pastikan jalur aset relatif atau menggunakan `{{ asset() }}` dengan base URL yang benar
-   Periksa Console browser untuk error 404 pada aset

### Halaman 404 saat mengakses rute

-   GitHub Pages tidak mendukung rute Laravel
-   Implementasikan routing sisi klien untuk SPA

### Error dalam proses build

-   Periksa log GitHub Actions untuk detail error
-   Pastikan dependensi NPM dan Composer terpasang dengan benar

## 9. Contoh Konfigurasi Tambahan

### Jika Menggunakan React dengan Laravel:

```javascript
// Sesuaikan dalam webpack.mix.js atau vite.config.js
// untuk memastikan semua aset dibangun dengan benar
```

### Jika Menggunakan Vue.js dengan Laravel:

```javascript
// Konfigurasi router Vue.js untuk mode history dengan base URL yang benar
// yang kompatibel dengan GitHub Pages
```

## 10. Sumber Daya Tambahan

-   [Dokumentasi GitHub Pages](https://docs.github.com/en/pages)
-   [Dokumentasi Laravel](https://laravel.com/docs)
-   [Dokumentasi GitHub Actions](https://docs.github.com/en/actions)

Semoga panduan ini membantu Anda men-deploy aplikasi Laravel 12 ke GitHub Pages dengan sukses!
