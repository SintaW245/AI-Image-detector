<?php
// result.php - Halaman hasil deteksi
session_start();

// Cek apakah ada hasil deteksi
if (!isset($_SESSION['detection_result'])) {
    header('Location: index.php');
    exit();
}

$result = $_SESSION['detection_result'];
$aiScore = isset($result['type']['ai_generated']) ? $result['type']['ai_generated'] : 0;
$aiPercentage = round($aiScore * 100, 2);

// Tentukan status
$isAI = $aiPercentage >= 50;
$status = $isAI ? 'AI Generated' : 'Human Created';
$statusColor = $isAI ? '#dc3545' : '#28a745';
$statusIcon = $isAI ? '🤖' : '👤';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Deteksi - AI Image Detector</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #253826ff 0%, #0a0a0aff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            animation: fadeInDown 0.6s ease-out;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .result-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease-out;
        }

        .status-badge {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        .score-container {
            text-align: center;
            margin: 40px 0;
        }

        .score-circle {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            position: relative;
        }

        .score-svg {
            transform: rotate(-90deg);
        }

        .score-bg {
            fill: none;
            stroke: #e0e0e0;
            stroke-width: 15;
        }

        .score-fill {
            fill: none;
            stroke-width: 15;
            stroke-linecap: round;
            transition: stroke-dashoffset 1s ease-out;
            animation: fillAnimation 1.5s ease-out;
        }

        .score-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            font-weight: 700;
        }

        .score-label {
            font-size: 1.2rem;
            color: #666;
            margin-top: 10px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .detail-item {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .detail-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .detail-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .interpretation {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
        }

        .interpretation h3 {
            color: #856404;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .interpretation p {
            color: #856404;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #133b2aff 0%, #1e1d1fff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 66, 52, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 56, 39, 0.6);
        }

        .btn-secondary {
            background: white;
            color: #0f4625ff;
            border: 2px solid #073a22ff;
        }

        .btn-secondary:hover {
            background: #093f29ff;
            color: white;
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

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes fillAnimation {
            from {
                stroke-dashoffset: 565;
            }
        }

        @media (max-width: 768px) {
            .result-card {
                padding: 25px;
            }

            .score-circle {
                width: 150px;
                height: 150px;
            }

            .score-text {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Hasil Deteksi Gambar</h1>
        </header>

        <div class="result-card">
            <div style="text-align: center;">
                <div class="status-badge" style="background-color: <?php echo $statusColor; ?>; color: white;">
                    <?php echo $statusIcon . ' ' . htmlspecialchars($status); ?>
                </div>
            </div>

            <div class="score-container">
                <div class="score-circle">
                    <svg width="200" height="200" class="score-svg">
                        <circle class="score-bg" cx="100" cy="100" r="90"></circle>
                        <circle class="score-fill" cx="100" cy="100" r="90" 
                                style="stroke: <?php echo $statusColor; ?>; 
                                       stroke-dasharray: 565; 
                                       stroke-dashoffset: <?php echo 565 - (565 * $aiScore); ?>;"></circle>
                    </svg>
                    <div class="score-text" style="color: <?php echo $statusColor; ?>;">
                        <?php echo $aiPercentage; ?>%
                    </div>
                </div>
                <div class="score-label">Kemungkinan Dibuat oleh AI</div>
            </div>

            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-icon">🎯</div>
                    <div class="detail-label">Status</div>
                    <div class="detail-value"><?php echo htmlspecialchars($status); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-icon">📈</div>
                    <div class="detail-label">Confidence Score</div>
                    <div class="detail-value"><?php echo $aiPercentage; ?>%</div>
                </div>
                <div class="detail-item">
                    <div class="detail-icon">⏱️</div>
                    <div class="detail-label">Waktu Deteksi</div>
                    <div class="detail-value"><?php echo date('H:i:s'); ?></div>
                </div>
            </div>

            <div class="interpretation">
                <h3>💡 Interpretasi Hasil</h3>
                <p>
                    <?php if ($aiPercentage >= 80): ?>
                        Gambar ini memiliki probabilitas sangat tinggi untuk dibuat oleh AI. Karakteristik visual menunjukkan pola yang konsisten dengan output dari model AI generatif seperti Stable Diffusion, MidJourney, atau DALL-E.
                    <?php elseif ($aiPercentage >= 50): ?>
                        Gambar ini kemungkinan besar dibuat oleh AI. Terdapat beberapa karakteristik yang umum ditemukan pada gambar hasil AI generation. Namun, disarankan untuk melakukan verifikasi lebih lanjut.
                    <?php elseif ($aiPercentage >= 20): ?>
                        Hasil analisis menunjukkan kemungkinan rendah hingga sedang bahwa gambar ini dibuat oleh AI. Gambar mungkin merupakan foto asli yang telah diedit, atau memiliki beberapa karakteristik yang mirip dengan AI-generated content.
                    <?php else: ?>
                        Gambar ini kemungkinan besar merupakan foto asli atau karya manusia. Karakteristik visual menunjukkan pola organik yang konsisten dengan fotografi tradisional atau seni digital buatan manusia.
                    <?php endif; ?>
                </p>
            </div>

            <div style="background: #e8f5e9; padding: 20px; border-radius: 10px; border-left: 4px solid #28a745;">
                <h3 style="color: #155724; margin-bottom: 10px;">ℹ️ Catatan Penting</h3>
                <ul style="color: #155724; padding-left: 20px; line-height: 1.8;">
                    <li>Hasil deteksi ini menggunakan teknologi AI dan tidak 100% akurat</li>
                    <li>Selalu gunakan pertimbangan konteks dan verifikasi tambahan</li>
                    <li>Beberapa gambar yang diedit secara ekstensif mungkin menghasilkan false positive</li>
                    <li>Teknologi AI terus berkembang dan dapat menghasilkan gambar yang semakin sulit dideteksi</li>
                </ul>
            </div>

            <div class="action-buttons">
                <a href="index.php" class="btn btn-primary">🔍 Deteksi Gambar Lain</a>
                <a href="history.php" class="btn btn-secondary">📊 Lihat Riwayat</a>
            </div>
        </div>
    </div>
</body>
</html>