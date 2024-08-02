<?php
include 'DatabaseController.php';

if (isset($_GET['code'])) {
    $tracking_code = $_GET['code'];

    $stmt = $pdo->prepare("SELECT * FROM parcels WHERE tracking_code = ?");
    $stmt->execute([$tracking_code]);
    $parcel = $stmt->fetch();

    if ($parcel) {
        $shipping_date = new DateTime($parcel['created_at']);
        $destination_date = clone $shipping_date;
        $destination_date->modify('+3 days');
?>
        <div class="tracking-info">
            <h1 class="status-title"><?= htmlspecialchars($parcel['status']) ?></h1>
            <h1 class="main-title uppercase"><i class="ph-fill ph-package"></i><?= htmlspecialchars($parcel['tracking_code']) ?></h1>
            <div class="route-info">
                <div class="addresses">
                    <div class="card">
                        <div class="content">
                            <h4>From</h4>
                            <h3 class="name"><?= htmlspecialchars($parcel['from_name']) ?></h3>
                            <p class="courses"><?= htmlspecialchars($parcel['from_address']) ?></p>
                        </div>
                        <div class="secondary">
                            <span class="month"><?= $shipping_date->format('M') ?></span>
                            <span class="day"><?= $shipping_date->format('d') ?></span>
                        </div>
                    </div>

                    <i class="ph-bold ph-arrow-right"></i>

                    <div class="card">
                        <div class="content">
                            <h4>To</h4>
                            <h3 class="name"><?= htmlspecialchars($parcel['to_name']) ?></h3>
                            <p class="courses"><?= htmlspecialchars($parcel['to_address']) ?></p>
                        </div>
                        <div class="secondary">
                            <span class="month"><?= $destination_date->format('M') ?></span>
                            <span class="day"><?= $destination_date->format('d') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="main-title">Tracking history</h1>

            <div class="history">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM parcel_statuses WHERE tracking_code = ? ORDER BY created_at DESC");
                $stmt->execute([$tracking_code]);
                $statuses = $stmt->fetchAll();

                foreach ($statuses as $status) {
                ?>
                    <div class="card">
                        <div class="secondary">
                            <span class="time"><?= (new DateTime($status['created_at']))->format('H:i') ?></span>
                            <span class="date"><?= (new DateTime($status['created_at']))->format('d.m.Y') ?></span>
                        </div>
                        <div class="content">
                            <h3 class="name"><?= htmlspecialchars($status['status']) ?></h3>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="tracking-info">
            <h1 class="main-title m-0"><i class="ph-fill ph-warning"></i>Tracking code not found</h1>
        </div>
<?php
    }
}

?>