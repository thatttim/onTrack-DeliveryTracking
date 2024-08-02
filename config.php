<?php

// Database configuration
define('DATABASE_SERVER', '');
define('DATABASE_USERNAME', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', '');

// App information
define('APP_NAME', 'onTrack');
define('APP_TITLE', 'Package Tracking');
define('APP_URL', '');
define('CODE_PREFIX', 'ON');
define('ADMIN_PASSWORD', 'admin');
define('IS_INSTALLED', 'NO');

// Tracking statuses
define('TRACKING_STATUSES', [
    'Pending',
    'Shipped',
    'In Transit',
    'Out for Delivery',
    'Delivered',
    'Returned',
    'Canceled'
]);

// SMTP configuration
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_SECURE', 'ssl');
define('SMTP_AUTH', 1);
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');
define('SMTP_SENDER_EMAIL', '');
define('SMTP_SENDER_NAME', '');
