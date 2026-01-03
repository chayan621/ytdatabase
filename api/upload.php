<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST allowed"
    ]);
    exit;
}

if (!isset($_FILES['image'])) {
    echo json_encode([
        "status" => false,
        "message" => "Image not found"
    ]);
    exit;
}

$folder = "../uploads/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$file = $_FILES['image'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

$allowed = ["jpg", "jpeg", "png", "gif"];
if (!in_array($ext, $allowed)) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid image type"
    ]);
    exit;
}

$filename = uniqid("img_") . "." . $ext;
$path = $folder . $filename;

if (move_uploaded_file($file['tmp_name'], $path)) {

    $baseUrl = "https://YOUR_RENDER_URL.onrender.com/uploads/";

    echo json_encode([
        "status" => true,
        "url" => $baseUrl . $filename
    ]);

} else {
    echo json_encode([
        "status" => false,
        "message" => "Upload failed"
    ]);
}