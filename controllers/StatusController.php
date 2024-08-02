<?php
include 'DatabaseController.php';
require 'MailController/General.php';
require 'MailController/SMTP.php';

// List of email domains to block
$blockedDomains = ['riverdale.com'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_code = $_POST['tracking_code'];
    $status = $_POST['status'];

    // Update parcel status
    $stmt = $pdo->prepare("UPDATE parcels SET status = ? WHERE tracking_code = ?");
    $stmt->execute([$status, $tracking_code]);

    // Insert into parcel_statuses
    $stmt = $pdo->prepare("INSERT INTO parcel_statuses (tracking_code, status) VALUES (?, ?)");
    $stmt->execute([$tracking_code, $status]);

    // Fetch to_email from parcels table
    $stmt = $pdo->prepare("SELECT to_email FROM parcels WHERE tracking_code = ?");
    $stmt->execute([$tracking_code]);
    $parcel = $stmt->fetch();

    if ($parcel && !empty($parcel['to_email'])) {
        $to_email = $parcel['to_email'];
        $emailDomain = substr(strrchr($to_email, "@"), 1);

        if (!in_array($emailDomain, $blockedDomains)) {
            $emailSubject = 'Status Update - ' . $status;

            // Load email template and replace placeholders
            $emailTemplate = file_get_contents('../assets/templates/email.html');
            $emailBody = str_replace(['{{tracking_code}}', '{{status}}'], [$tracking_code, $status], $emailTemplate);

            // Configure and send the email
            $mail = new MailController\MailController\MailController();
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->Port = SMTP_PORT;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->SMTPAuth = SMTP_AUTH;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->setFrom(SMTP_SENDER_EMAIL, SMTP_SENDER_NAME);
            $mail->addAddress($to_email);
            $mail->Subject = $emailSubject;
            $mail->Body = $emailBody;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            if (!$mail->send()) {
                // Handle error if email is not sent
                error_log('Email not sent: ' . $mail->ErrorInfo);
            }
        }
    }

    header('Location: /admin');
    exit();
}
?>
