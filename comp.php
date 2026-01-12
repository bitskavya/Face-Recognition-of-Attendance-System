<?php
function compareFaces($imagePath1, $imagePath2) {
    $api_key = "6_Uoa7BazlNpyLTPb-7w8k-wPj7qLWAG";
    $api_secret = "RDvgi6pbcTnF_abIqHPdjrtm19ptUPgx";

    $image1 = new CURLFile($imagePath1);
    $image2 = new CURLFile($imagePath2);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api-us.faceplusplus.com/facepp/v3/compare");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "api_key" => $api_key,
        "api_secret" => $api_secret,
        "image_file1" => $image1,
        "image_file2" => $image2
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['confidence'])) {
        $confidence = $result['confidence'];
        // Adjust threshold: usually >70 means same person
        if ($confidence > 70) {
            return ["status" => true, "confidence" => $confidence];
        } else {
            return ["status" => false, "confidence" => $confidence];
        }
    } else {
        return ["status" => false, "error" => $response];
    }
}
?>