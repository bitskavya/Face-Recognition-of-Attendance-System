<?php
// Read JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["image"]) || !isset($data["rollno"])) {
    echo "❌ Invalid data.";
    exit;
}

$img = $data["image"];
$rollno = preg_replace("/[^0-9]/", "", $data["rollno"]); // only digits

if (strlen($rollno) !== 4) {
    echo "❌ Roll number must be 4 digits.";
    exit;
}

// Decode image
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$imageData = base64_decode($img);

// Save in uploads/uploads2 with rollno.png
$folder = "uploads/";
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$file = $folder . $rollno . ".png";
file_put_contents($file, $imageData);

echo "✅ Image saved as $rollno.png";
?>
