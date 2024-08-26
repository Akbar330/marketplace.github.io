<?php
if (isset($_GET['number'])) {
    $trackingNumber = $_GET['number'];
    $apiKey = 'YOUR_API_KEY';
    $apiUrl = "https://api.tracking.com/v1/track?number={$trackingNumber}&apiKey={$apiKey}";

    $response = file_get_contents($apiUrl);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['status'])) {
            echo json_encode([
                'status' => $data['status'],
                'location' => $data['location']
            ]);
        } else {
            echo json_encode(['error' => 'Nomor resi tidak ditemukan.']);
        }
    } else {
        echo json_encode(['error' => 'Error saat mengambil data.']);
    }
} else {
    echo json_encode(['error' => 'Nomor resi tidak diberikan.']);
}
