<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Get the file name and force it to have a .jpg extension
    $fileName = basename(parse_url($url, PHP_URL_PATH));
    $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';

    // Use cURL to download the file
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data === false) {
        echo "Failed to download file.";
        exit;
    }

    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($data));

    echo $data;
    exit;
} else {
    echo "No file URL provided.";
}
?>
