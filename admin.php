<?php
require_once 'config.php';
if (IS_INSTALLED === 'NO') {
    header('Location: install');
    exit();
}

include 'controllers/DatabaseController.php';

session_start();

$correct_password = ADMIN_PASSWORD;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] == $correct_password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error_message = "Incorrect password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME . " | Admin Panel" ?></title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="assets/images/favicon.png" type="assets/image/png">
</head>

<body>
    <header class="header admin">
        <div class="navbar">
            <a href="./" class="logo"><?= APP_NAME ?></a>
            <?php

            if (isset($_SESSION['authenticated'])) {
            ?>
                <button id="openModalBtn" class="btn">New Tracking</button>
            <?php } ?>
        </div>
    </header>

    <main class="admin">
        <?php

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        ?>



            <form method="POST" action="" class="login-form">
                <h2>Admin Panel</h2>
                <input type="password" name="password" required>
                <button type="submit">Sign In</button>
                <?php if (isset($error_message)) : ?>
                    <p class="error"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
            </form>

        <?php
            exit;
        }

        include 'controllers/DatabaseController.php';

        $statuses = TRACKING_STATUSES;
        $parcelsByStatus = [];

        foreach ($statuses as $status) {
            $parcelsByStatus[$status] = $pdo->query("SELECT * FROM parcels WHERE status = '$status'")->fetchAll();
        }
        ?>


        <?php foreach ($statuses as $status) : ?>
            <?php if (!empty($parcelsByStatus[$status])) : ?>
                <h1 class="main-title"><i class="ph-fill ph-package"></i><?= htmlspecialchars($status) ?></h1>
                <table class="tracking-table">
                    <tr>
                        <th>Tracking Code</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                    <?php foreach ($parcelsByStatus[$status] as $parcel) : ?>
                        <tr>
                            <td><a href="#" class="tracking-link" data-code="<?= htmlspecialchars($parcel['tracking_code']) ?>"><?= htmlspecialchars($parcel['tracking_code']) ?></a></td>
                            <td><?= htmlspecialchars($parcel['from_address']) ?></td>
                            <td><?= htmlspecialchars($parcel['to_address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="footer">
            <a href="controllers/LogoutController">Sign Out</a>
            <p><?= APP_NAME ?></p>
        </div>

    </main>

    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div id="orderDetails"></div>
            <form id="updateStatusForm" method="POST" action="controllers/StatusController">
                <input type="hidden" name="tracking_code" id="trackingCode">
                <select name="status" id="statusSelect">
                    <?php foreach ($statuses as $status) : ?>
                        <option value="<?= htmlspecialchars($status) ?>"><?= htmlspecialchars($status) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="update">Update Status</button>
            </form>
        </div>
    </div>

    <div id="addFormModal" class="modal">
        <div class="modal-content">
            <form method="POST" action="controllers/GenerateController">
                <h5>From</h5>
                <label>Address</label>
                <input type="text" name="from_address" required><br>
                <label>Name</label>
                <input type="text" name="from_name" required><br>
                <div class="flex-row">
                    <div>
                        <label>Phone</label>
                        <input type="text" name="from_phone" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="from_email" required>
                    </div>
                </div>
                <hr>
                <h5>To</h5>
                <label>Address</label>
                <input type="text" name="to_address" required><br>
                <label>Name</label>
                <input type="text" name="to_name" required><br>
                <div class="flex-row">
                    <div>
                        <label>Phone</label>
                        <input type="text" name="to_phone" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="to_email" required>
                    </div>
                </div>
                <button type="submit" name="GenerateController">Generate Tracking Code</button>
            </form>
        </div>
    </div>

    <script src="assets/js/admin.js"></script>
</body>

</html>