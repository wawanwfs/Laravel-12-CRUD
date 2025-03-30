<?php

/**
 * Script untuk menghasilkan versi statis dari aplikasi Laravel
 * 
 * Gunakan script ini di pipeline build GitHub untuk menghasilkan
 * konten statis dari aplikasi Laravel yang dapat di-deploy ke GitHub Pages.
 * 
 * Penggunaan: php scripts/static-build.php
 */

// Daftar route yang akan di-generate secara statis
$routes = [
    '/' => 'index.html',
    // Tambahkan route lain yang ingin di-generate
    // contoh: '/about' => 'about.html',
];

// Direktori output untuk file statis
$outputDir = '_site';

// Pastikan direktori output ada
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

// Jalankan server PHP untuk mengakses aplikasi
echo "Memulai server PHP...\n";
$serverCommand = "php -S localhost:8000 -t public > /dev/null 2>&1 & echo $!";
$pid = shell_exec($serverCommand);
$pid = trim($pid);

// Beri waktu server untuk siap
sleep(3);
echo "Server berjalan dengan PID: $pid\n";

// Generate file statis untuk setiap route
foreach ($routes as $route => $outputFile) {
    echo "Generating: $route -> $outputFile\n";

    // Buat direktori jika diperlukan (untuk nested routes)
    $outputPath = $outputDir . '/' . $outputFile;
    $outputDirname = dirname($outputPath);
    if (!is_dir($outputDirname)) {
        mkdir($outputDirname, 0755, true);
    }

    // Ambil konten HTML dari route
    $url = 'http://localhost:8000' . $route;
    $html = file_get_contents($url);

    if ($html === false) {
        echo "Error: Tidak dapat mengakses $url\n";
        continue;
    }

    // Simpan ke file
    file_put_contents($outputPath, $html);
    echo "Berhasil di-generate: $outputPath\n";
}

// Matikan server
echo "Mematikan server PHP...\n";
shell_exec("kill $pid");

// Buat file .nojekyll untuk mencegah pemrosesan Jekyll
file_put_contents("$outputDir/.nojekyll", '');

// Buat file .htaccess untuk SPA fallback routing
$htaccess = <<<'HTACCESS'
RewriteEngine On
RewriteBase /
RewriteRule ^index\.html$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.html [L]
HTACCESS;
file_put_contents("$outputDir/.htaccess", $htaccess);

// Buat file 404.html untuk SPA routing
$html404 = <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redirecting...</title>
    <script>
        // Redirect semua 404 ke halaman utama untuk SPA routing
        window.location.href = "/";
    </script>
</head>
<body>
    <p>Redirecting to homepage...</p>
</body>
</html>
HTML;
file_put_contents("$outputDir/404.html", $html404);

echo "Build statis selesai!\n";
