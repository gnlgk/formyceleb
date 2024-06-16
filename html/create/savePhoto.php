<?php
include "../connect/connect.php";

function fetchPhotosAndStoreInDB($jsonUrl, $connect) {
    // cURL을 사용하여 JSON 파일을 가져옵니다.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $jsonUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);

    if ($json === false) {
        echo "Failed to fetch JSON from $jsonUrl\n";
        return;
    }
    
    // JSON을 배열로 디코드합니다.
    $photos = json_decode($json, true);
    
    if ($photos === null) {
        echo "Failed to decode JSON from $jsonUrl\n";
        return;
    }

    // 데이터베이스에 이미지를 추가합니다.
    $stmt = $connect->prepare("INSERT INTO photos (image_url) VALUES (?)");
    
    foreach ($photos as $photo) {
        if (isset($photo['image_url'])) {
            // 이미지가 데이터베이스에 존재하는지 확인합니다.
            $existing = $connect->query("SELECT COUNT(*) FROM photos WHERE image_url = '{$photo['image_url']}'")->fetch_assoc();
            
            if ($existing['COUNT(*)'] == 0) {
                // 이미지가 존재하지 않는 경우에만 추가합니다.
                $stmt->bind_param('s', $photo['image_url']);
                $stmt->execute();
            }
        }
    }

    $stmt->close();
}

// JSON 파일을 가져와서 데이터베이스에 저장
$jsonUrls = [
    'https://gnlgk.github.io/class2024/json/nmixx.json',
    'https://gnlgk.github.io/class2024/json/stayc.json',
    'https://gnlgk.github.io/class2024/json/QWER.json',
    'https://gnlgk.github.io/class2024/json/LESSERAFIM.json',
    'https://gnlgk.github.io/class2024/json/ILLIT.json',
    'https://gnlgk.github.io/class2024/json/BABYMONSTER.json',
    'https://gnlgk.github.io/class2024/json/newjeans.json',
    'https://gnlgk.github.io/class2024/json/aespa.json',
    'https://gnlgk.github.io/class2024/json/ive.json'
];

foreach ($jsonUrls as $url) {
    fetchPhotosAndStoreInDB($url, $connect);
}

echo "Photos have been successfully imported.";

$connect->close();
?>
