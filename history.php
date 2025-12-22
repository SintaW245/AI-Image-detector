<?php
// history.php - Halaman riwayat deteksi
session_start();

// Ambil riwayat dari session
$history = isset($_SESSION['history']) ? $_SESSION['history'] : array();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Deteksi - AI Image Detector</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #2e5f4fff 0%, #0f0f0fff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
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

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .main-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease-out;
            min-height: 400px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .stats {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-icon {
            font-size: 1.5rem;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }

        .btn {
            padding: 10px 25px;
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
            background: linear-gradient(135deg, #325f52ff 0%, #111111ff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .history-table thead {
            background: linear-gradient(135deg, #356152ff 0%, #0d0d0eff 100%);
            color: white;
        }

        .history-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        .history-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .history-table tbody tr {
            transition: all 0.3s ease;
        }

        .history-table tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-ai {
            background: #ffe0e0;
            color: #dc3545;
        }

        .badge-human {
            background: #d4edda;
            color: #28a745;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-text {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
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
                padding: 20px;
                overflow-x: auto;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .stats {
                justify-content: space-around;
            }

            .history-table {
                font-size: 0.9rem;
            }

            .history-table th,
            .history-table td {
                padding: 10px 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Riwayat Deteksi</h1>
            <p>Lihat semua riwayat deteksi gambar Anda</p>
        </header>

        <div class="main-card">
            <div class="toolbar">
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-icon">📸</div>
                        <div class="stat-info">
                            <span class="stat-label">Total Deteksi</span>
                            <span class="stat-value"><?php echo count($history); ?></span>
                        </div>
                    </div>
                    <?php
                    $aiCount = 0;
                    $humanCount = 0;
                    foreach ($history as $item) {
                        if ($item['ai_score'] >= 0.5) {
                            $aiCount++;
                        } else {
                            $humanCount++;
                        }
                    }
                    ?>
                    <div class="stat-item">
                        <div class="stat-icon">🤖</div>
                        <div class="stat-info">
                            <span class="stat-label">AI Generated</span>
                            <span class="stat-value"><?php echo $aiCount; ?></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">👤</div>
                        <div class="stat-info">
                            <span class="stat-label">Human Created</span>
                            <span class="stat-value"><?php echo $humanCount; ?></span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="index.php" class="btn btn-primary">← Kembali</a>
                    <?php if (count($history) > 0): ?>
                        <form method="POST" action="clear_history.php" style="display: inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus semua riwayat?')">🗑️ Hapus</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (count($history) > 0): ?>
                <div style="overflow-x: auto;">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Waktu</th>
                                <th>AI Score</th>
                                <th>Status</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $index => $item): ?>
                                <?php
                                $aiPercentage = round($item['ai_score'] * 100, 2);
                                $isAI = $aiPercentage >= 50;
                                $statusBadge = $isAI ? 'badge-ai' : 'badge-human';
                                $statusText = $isAI ? '🤖 AI' : '👤 Human';
                                $progressColor = $isAI ? '#dc3545' : '#28a745';
                                ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars(substr($item['image_name'], 0, 30)); ?></strong>
                                        <?php if (strlen($item['image_name']) > 30) echo '...'; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['timestamp']); ?></td>
                                    <td><strong><?php echo $aiPercentage; ?>%</strong></td>
                                    <td>
                                        <span class="badge <?php echo $statusBadge; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo $aiPercentage; ?>%; background: <?php echo $progressColor; ?>;"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <div class="empty-text">Belum ada riwayat deteksi</div>
                    <a href="index.php" class="btn btn-primary">🔍 Mulai Deteksi</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>