<?php
include 'DatabaseController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_code = CODE_PREFIX . strtoupper(uniqid());
    $from_address = $_POST['from_address'];
    $from_name = $_POST['from_name'];
    $from_phone = $_POST['from_phone'];
    $from_email = $_POST['from_email'];
    $to_address = $_POST['to_address'];
    $to_name = $_POST['to_name'];
    $to_phone = $_POST['to_phone'];
    $to_email = $_POST['to_email'];
    $status = 'Pending';

    $stmt = $pdo->prepare("INSERT INTO parcels (tracking_code, from_address, from_name, from_phone, from_email, to_address, to_name, to_phone, to_email, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$tracking_code, $from_address, $from_name, $from_phone, $from_email, $to_address, $to_name, $to_phone, $to_email, $status]);

    $url = APP_URL . 'controllers/StatusController';
    $data = ['tracking_code' => $tracking_code, 'status' => $status];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);

    header('Location: ../admin.php');
    exit();
}
?>
