<?php
include 'DatabaseController.php';

$response = ['success' => false];

if (isset($_GET['code'])) {
    $tracking_code = $_GET['code'];
    $stmt = $pdo->prepare("SELECT * FROM parcels WHERE tracking_code = ?");
    $stmt->execute([$tracking_code]);
    $parcel = $stmt->fetch();

    if ($parcel) {
        $statuses_stmt = $pdo->prepare("SELECT * FROM parcel_statuses WHERE tracking_code = ? ORDER BY created_at ASC");
        $statuses_stmt->execute([$tracking_code]);
        $statuses = $statuses_stmt->fetchAll();

        ob_start();
?>
        <form>
            <h5>From</h5>
            <label>Address</label>
            <input type="text" name="from_address" value="<?= htmlspecialchars($parcel['from_address']) ?>" disabled><br>
            <label>Name</label>
            <input type="text" name="from_name" value="<?= htmlspecialchars($parcel['from_name']) ?>" disabled><br>
            <div class="flex-row">
                <div>
                    <label>Phone</label>
                    <input type="text" name="from_phone" value="<?= htmlspecialchars($parcel['from_phone']) ?>" disabled>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="from_email" value="<?= htmlspecialchars($parcel['from_email']) ?>" disabled>
                </div>
            </div>
            <hr>
            <h5>To</h5>
            <label>Address</label>
            <input type="text" name="to_address" value="<?= htmlspecialchars($parcel['to_address']) ?>" disabled><br>
            <label>Name</label>
            <input type="text" name="to_name" value="<?= htmlspecialchars($parcel['to_name']) ?>" disabled><br>
            <div class="flex-row">
                <div>
                    <label>Phone</label>
                    <input type="text" name="to_phone" value="<?= htmlspecialchars($parcel['to_phone']) ?>" disabled>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="to_email" value="<?= htmlspecialchars($parcel['to_email']) ?>" disabled>
                </div>
            </div>

            <hr>

            <h5>Status</h5>
        </form>



<?php
        $response['html'] = ob_get_clean();
        $response['success'] = true;
        $response['parcel'] = $parcel;
    }
}

echo json_encode($response);
?>