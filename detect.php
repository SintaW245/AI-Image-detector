<?php
// detect.php - Proses deteksi gambar AI
session_start();

// Konfigurasi API
define('API_USER', '154002814');
define('API_SECRET', 'fa5Vs6VvTbmfh2gqiYAH5TAatb4MDvA2');
define('API_URL', 'https://api.sightengine.com/1.0/check.json');

// Fungsi untuk memanggil API Sightengine
function detectAIImage($imageData, $isUrl = false) {
    $params = array(
        'api_user' => API_USER,
        'api_secret' => API_SECRET,
        'models' => 'genai'
    );
    
    if ($isUrl) {
        $params['url'] = $imageData;
        $url = API_URL . '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    } else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array_merge($params, array('media' => $imageData)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }
    
    if ($httpCode !== 200) {
        return array('error' => 'API request failed with code: ' . $httpCode);
    }
    
    return json_decode($response, true);
}

// Fungsi untuk menyimpan hasil ke session
function saveToHistory($result, $imageName) {
    if (!isset($_SESSION['history'])) {
        $_SESSION['history'] = array();
    }
    
    $historyItem = array(
        'image_name' => $imageName,
        'ai_score' => isset($result['type']['ai_generated']) ? $result['type']['ai_generated'] : 0,
        'timestamp' => date('Y-m-d H:i:s'),
        'result' => $result
    );
    
    array_unshift($_SESSION['history'], $historyItem);
    
    // Batasi history hanya 50 item
    if (count($_SESSION['history']) > 50) {
        array_pop($_SESSION['history']);
    }
}

// Validasi request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Proses upload file
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = array('image/jpeg', 'image/png', 'image/webp');
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    
    // Validasi tipe file
    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['message'] = 'Format file tidak didukung! Gunakan JPG, PNG, atau WEBP.';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit();
    }
    
    // Validasi ukuran file (5MB)
    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['message'] = 'Ukuran file terlalu besar! Maksimal 5MB.';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit();
    }
    
    // Deteksi gambar
    $imageData = new CURLFile($_FILES['image']['tmp_name'], $fileType, $_FILES['image']['name']);
    $result = detectAIImage($imageData, false);
    
    if (isset($result['error'])) {
        $_SESSION['message'] = 'Terjadi kesalahan: ' . $result['error'];
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit();
    }
    
    saveToHistory($result, $_FILES['image']['name']);
    $_SESSION['detection_result'] = $result;
    header('Location: result.php');
    exit();
}

// Proses URL
if (isset($_POST['image_url']) && !empty($_POST['image_url'])) {
    $imageUrl = filter_var($_POST['image_url'], FILTER_VALIDATE_URL);
    
    if (!$imageUrl) {
        $_SESSION['message'] = 'URL gambar tidak valid!';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit();
    }
    
    // Deteksi gambar dari URL
    $result = detectAIImage($imageUrl, true);
    
    if (isset($result['error'])) {
        $_SESSION['message'] = 'Terjadi kesalahan: ' . $result['error'];
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit();
    }
    
    saveToHistory($result, basename($imageUrl));
    $_SESSION['detection_result'] = $result;
    header('Location: result.php');
    exit();
}

// Jika tidak ada file atau URL
$_SESSION['message'] = 'Silakan upload gambar atau masukkan URL gambar!';
$_SESSION['message_type'] = 'error';
header('Location: index.php');
exit();
?>