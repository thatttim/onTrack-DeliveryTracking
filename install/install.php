<?php
header('Content-Type: application/json');
define('ROOT', realpath(__DIR__ . '/..') . '/');

// Make sure all the required fields are present
$required_fields = [
    'database_host', 'database_name', 'database_username', 'database_password', 
    'app_name', 'app_title', 'app_url', 'code_prefix', 'admin_password', 
    'smtp_host', 'smtp_port', 'smtp_secure', 'smtp_auth', 'smtp_username', 
    'smtp_password', 'smtp_sender_email', 'smtp_sender_name'
];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(['status' => 'error', 'message' => 'One of the required fields is missing.']);
        exit;
    }
}

foreach ($required_fields as $key) {
    $_POST[$key] = str_replace('\'', '\\\'', $_POST[$key]);
}

// Attempt to connect to the database
mysqli_report(MYSQLI_REPORT_OFF);
try {
    $database = new mysqli($_POST['database_host'], $_POST['database_username'], $_POST['database_password']);
} catch (\Exception $exception) {
    echo json_encode(['status' => 'error', 'message' => 'The database connection has failed: ' . $exception->getMessage()]);
    exit;
}

if ($database->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'The database connection has failed!']);
    exit;
}

// Create the database if it doesn't exist
$create_db_query = "CREATE DATABASE IF NOT EXISTS `{$_POST['database_name']}`";
if (!$database->query($create_db_query)) {
    echo json_encode(['status' => 'error', 'message' => 'Error creating database: ' . $database->error]);
    exit;
}

// Select the database
$database->select_db($_POST['database_name']);
if ($database->error) {
    echo json_encode(['status' => 'error', 'message' => 'Error selecting database: ' . $database->error]);
    exit;
}

$database->set_charset('utf8mb4');

// Success check
if (true) {

    // Prepare the config file content
    $config_content = <<<CONFIG
<?php

// Database configuration
define('DATABASE_SERVER', '{$_POST['database_host']}');
define('DATABASE_USERNAME', '{$_POST['database_username']}');
define('DATABASE_PASSWORD', '{$_POST['database_password']}');
define('DATABASE_NAME', '{$_POST['database_name']}');

// App information
define('APP_NAME', '{$_POST['app_name']}');
define('APP_TITLE', '{$_POST['app_title']}');
define('APP_URL', '{$_POST['app_url']}');
define('CODE_PREFIX', '{$_POST['code_prefix']}');
define('ADMIN_PASSWORD', '{$_POST['admin_password']}');
define('IS_INSTALLED', 'YES');

// Tracking statuses
define('TRACKING_STATUSES', [
    'Pending', 'Shipped', 'In Transit', 'Out for Delivery', 'Delivered', 'Returned', 'Canceled'
]);

// SMTP configuration
define('SMTP_HOST', '{$_POST['smtp_host']}');
define('SMTP_PORT', {$_POST['smtp_port']});
define('SMTP_SECURE', '{$_POST['smtp_secure']}');
define('SMTP_AUTH', {$_POST['smtp_auth']});
define('SMTP_USERNAME', '{$_POST['smtp_username']}');
define('SMTP_PASSWORD', '{$_POST['smtp_password']}');
define('SMTP_SENDER_EMAIL', '{$_POST['smtp_sender_email']}');
define('SMTP_SENDER_NAME', '{$_POST['smtp_sender_name']}');

CONFIG;

    // Write the new config file
    file_put_contents(ROOT . 'config.php', $config_content);

    // Run SQL
    $dump_content = file_get_contents(ROOT . 'install/dump.sql');
    $queries = explode(';', $dump_content);

    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            $database->query($query);
            if ($database->error) {
                echo json_encode(['status' => 'error', 'message' => 'Error when running the database query: ' . $query . ' - ' . $database->error]);
                exit;
            }
        }
    }

    // Function to delete a directory and its contents
    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    // Delete the /install directory
    try {
        deleteDir(ROOT . 'install');
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting install directory: ' . $e->getMessage()]);
        exit;
    }

    echo json_encode(['status' => 'success', 'message' => '']);
    exit;
}
?>
