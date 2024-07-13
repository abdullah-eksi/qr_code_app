<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['qrLogo'])) {
    $targetDir = 'cache_image/';
    $fileName = uniqid() . '_' . basename($_FILES['qrLogo']['name']);
    $targetFilePath = $targetDir . $fileName;

    // İzin verilen dosya türleri
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['qrLogo']['tmp_name']);

    // Maksimum dosya boyutu (5MB)
    $maxFileSize = 5 * 1024 * 1024;

    // Dosya adı kontrolü
    $safeFileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $fileName);

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Geçersiz dosya türü.']);
    } elseif ($_FILES['qrLogo']['size'] > $maxFileSize) {
        echo json_encode(['success' => false, 'message' => 'Dosya boyutu çok büyük.']);
    } elseif ($fileName !== $safeFileName) {
        echo json_encode(['success' => false, 'message' => 'Geçersiz dosya adı.']);
    } else {
        if (move_uploaded_file($_FILES['qrLogo']['tmp_name'], $targetFilePath)) {
            // Yüklenen dosya izinlerini sıkılaştır
            chmod($targetFilePath, 0644);
            echo json_encode(['success' => true, 'path' => $targetFilePath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Dosya yüklenirken bir hata oluştu.']);
        }
    }
}
?>
