<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['qrLogo'])) {
    $targetDir = 'cache_image/';
    $fileName = uniqid() . '_' . basename($_FILES['qrLogo']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['qrLogo']['tmp_name'], $targetFilePath)) {
        echo json_encode(['success' => true, 'path' => $targetFilePath]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dosya yüklenirken bir hata oluştu.']);
    }
}
?>
