<?php
require_once 'config.php';
if (IS_INSTALLED === 'NO') {
    header('Location: install');
    exit();
}

include 'controllers/DatabaseController.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME . " | " . APP_TITLE ?></title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="assets/images/favicon.png" type="assets/image/png">
</head>

<body class="bg-gradient">
    <header class="header" >
        <div class="navbar">
            <a href="./" class="logo"><?= APP_NAME ?></a>
            <a href="javascript:void(0);" class="btn" id="trackingHistoryBtn">Tracking History</a>
        </div>

        <div class="hero">
            <h1>Track your order</h1>
            <p>All-in-one order tracking system</p>
        </div>

        <div class="search">
            <button onclick="trackParcel()"><i class="ph-bold ph-magnifying-glass"></i></button>
            <input type="text" id="trackingCode" placeholder="Tracking Number">
        </div>
    </header>

    <main id="trackingResult"></main>

    <!-- Modal -->
    <div id="trackingHistoryModal" class="modal">
        <div class="modal-content">
            <h5>Tracking History</h5>
            <ul id="trackingHistoryList"></ul>
            <button id="clearHistoryBtn">Clear History</button>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>
