<?php
// about.php - Halaman tentang aplikasi
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - AI Image Detector</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #14352eff 0%, #171718ff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            animation: fadeInDown 0.6s ease-out;
        }

        header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .main-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease-out;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #193d35ff;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-content {
            color: #555;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 25px;
        }

        .feature-item {
            background: linear-gradient(135deg, #f8f9ff 0%, #85d6c583 100%);
            padding: 25px;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            border-color: #17412aff;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .feature-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .feature-desc {
            color: #666;
            line-height: 1.6;
        }

        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .tech-badge {
            background: linear-gradient(135deg, #1f4e4aff 0%, #0c0c0cff 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .tech-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn {
            background: linear-gradient(135deg, #12533eff 0%, #0f0f0fff 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
        }

        .info-box h4 {
            color: #856404;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box p {
            color: #856404;
            line-height: 1.6;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .team-member {
            text-align: center;
            padding: 25px;
            background: #f8f9ff;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .team-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #23443aff 0%, #141414ff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 15px;
            color: white;
        }

        .team-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .team-role {
            color: #666;
            font-size: 0.9rem;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .main-card {
                padding: 25px;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .feature-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>ℹ️ Tentang AI Image Detector</h1>
        </header>

        <div class="main-card">
            <div class="section">
                <h2 class="section-title">
                    <span>🎯</span>
                    Tentang Aplikasi
                </h2>
                <div class="section-content">
                    <p>
                        <strong>AI Image Detector</strong> adalah aplikasi web REST Client yang dikembangkan untuk mendeteksi apakah suatu gambar dibuat oleh kecerdasan buatan (AI) atau karya manusia. Aplikasi ini menggunakan teknologi machine learning terkini dari Sightengine API untuk menganalisis karakteristik visual gambar.
                    </p>
                    <p style="margin-top: 15px;">
                        Dengan meningkatnya penggunaan AI generator seperti Stable Diffusion, MidJourney, DALL-E, dan lainnya, semakin penting untuk dapat membedakan konten yang dihasilkan AI dari konten asli. Aplikasi ini hadir untuk membantu verifikasi keaslian gambar dengan mudah dan cepat.
                    </p>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">
                    <span>✨</span>
                    Fitur Utama
                </h2>
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-title">Deteksi Cepat</div>
                        <div class="feature-desc">Hasil analisis dalam hitungan detik dengan akurasi tinggi menggunakan API Sightengine</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📤</div>
                        <div class="feature-title">Multi Upload</div>
                        <div class="feature-desc">Mendukung upload file lokal atau deteksi via URL gambar</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📊</div>
                        <div class="feature-title">Riwayat Deteksi</div>
                        <div class="feature-desc">Simpan dan lihat semua riwayat deteksi Anda dengan detail lengkap</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🔒</div>
                        <div class="feature-title">Privacy First</div>
                        <div class="feature-desc">Gambar tidak disimpan di server, keamanan data terjamin</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📱</div>
                        <div class="feature-title">Responsive Design</div>
                        <div class="feature-desc">Tampilan yang optimal di berbagai perangkat dan ukuran layar</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🎨</div>
                        <div class="feature-title">Modern UI</div>
                        <div class="feature-desc">Antarmuka yang indah, intuitif, dan mudah digunakan</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">
                    <span>🛠️</span>
                    Teknologi yang Digunakan
                </h2>
                <div class="tech-stack">
                    <div class="tech-badge">
                        <span>🐘</span> PHP 7.4+
                    </div>
                    <div class="tech-badge">
                        <span>🎨</span> HTML5 & CSS3
                    </div>
                    <div class="tech-badge">
                        <span>⚡</span> JavaScript
                    </div>
                    <div class="tech-badge">
                        <span>🔌</span> Sightengine API
                    </div>
                    <div class="tech-badge">
                        <span>🔄</span> cURL
                    </div>
                    <div class="tech-badge">
                        <span>📦</span> Session Storage
                    </div>
                    <div class="tech-badge">
                        <span>🚀</span> Git & GitHub
                    </div>
                    <div class="tech-badge">
                        <span>⚙️</span> GitHub Actions
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">
                    <span>🔬</span>
                    Cara Kerja
                </h2>
                <div class="section-content">
                    <ol style="padding-left: 20px; line-height: 2;">
                        <li><strong>Upload Gambar:</strong> Pengguna mengupload gambar melalui file atau URL</li>
                        <li><strong>Preprocessing:</strong> Gambar divalidasi format dan ukurannya</li>
                        <li><strong>API Request:</strong> Gambar dikirim ke Sightengine API untuk dianalisis</li>
                        <li><strong>AI Analysis:</strong> Machine learning model menganalisis karakteristik visual</li>
                        <li><strong>Score Calculation:</strong> API mengembalikan confidence score (0-100%)</li>
                        <li><strong>Result Display:</strong> Hasil ditampilkan dengan visualisasi yang jelas</li>
                    </ol>
                </div>

                <div class="info-box">
                    <h4>💡 Catatan Penting</h4>
                    <p>
                        Sistem deteksi ini menggunakan algoritma machine learning yang telah dilatih dengan jutaan gambar. Namun, tidak ada sistem yang 100% akurat. Selalu gunakan konteks dan pertimbangan tambahan saat membuat keputusan berdasarkan hasil deteksi.
                    </p>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">
                    <span>👥</span>
                    Tim Pengembang
                </h2>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="team-avatar">👨‍💻</div>
                        <div class="team-name">Anggota 1</div>
                        <div class="team-role">Project Lead</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">👩‍💻</div>
                        <div class="team-name">Anggota 2</div>
                        <div class="team-role">Backend Developer</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">👨‍🎨</div>
                        <div class="team-name">Anggota 3</div>
                        <div class="team-role">Frontend Developer</div>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">👩‍🔬</div>
                        <div class="team-name">Anggota 4</div>
                        <div class="team-role">QA & Testing</div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <a href="index.php" class="btn">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>7