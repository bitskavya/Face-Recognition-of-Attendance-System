<?php
$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data['image'])){
    die("No image received");
}

$imageData = $data['image'];
$imageData = str_replace("data:image/png;base64,", "", $imageData);
$imageData = base64_decode($imageData);

$fileName = "Regface_" . date("Y-m-d_H-i-s") . ".png";
file_put_contents("uploads/uploads2/".$fileName, $imageData);

echo "regesitered sucessfully ";
?>
