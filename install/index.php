<?php
define('ROOT', realpath(__DIR__ . '/..') . '/');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <link rel="shortcut icon" href="./assets/favicons/favicon.ico">

    <title>
        onTrack Installation
    </title>
</head>

<!-- © 2024 Framework Group -->

<body>

    <div class="container">
        <header class="card header mt-4">
            <div class="card-body d-flex">
                <div class="mr-3">
                    <img src="./assets/images/logo.png" class="img-fluid logo" alt="Framework logo" />
                </div>

                <div class="d-flex flex-column justify-content-center">
                    <h1>Installation</h1>
                    <p class="subheader d-flex flex-row">
                        <span class="text-muted">
                            <a class="text-gray-500">
                                onTrack
                            </a> by <a href="https://framework.ge" target="_blank" class="text-gray-500">Framework</a>
                        </span>
                    </p>
                </div>
            </div>
        </header>
    </div>

    <main class="main mb-4">
        <div class="container">
            <div class="row">

                <div class="col col-md-3 d-none d-md-block">
                    <div class="card">
                        <div class="card-body">
                            <nav class="nav sidebar-nav">
                                <ul class="sidebar mb-0" id="sidebar-ul">
                                    <li class="nav-item active">
                                        <a href="#requirements" class="navigator nav-link">Requirements</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#setup" class="navigator nav-link" style="display: none">Setup</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#finish" class="navigator nav-link" style="display: none">Finish</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col" id="content">
                    <div class="card">
                        <div class="card-body">

                            <section id="requirements" style="display: none">
                                <?php $requirements = true ?>
                                <h2 class="mb-4">Requirements</h2>

                                <div class="table-responsive table-custom-container">
                                    <table class="table table-custom">
                                        <thead>
                                            <tr>
                                                <th>Requirement</th>
                                                <th>Required</th>
                                                <th>Current</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP Version</td>
                                                <td>7.4 or above</td>
                                                <td>
                                                    <?= PHP_VERSION ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php if (version_compare(PHP_VERSION, '7.4.0', '>=')) : ?>
                                                        ✅
                                                    <?php else : ?>
                                                        ❌
                                                        <?php $requirements = false; ?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>OpenSSL</td>
                                                <td>Enabled</td>
                                                <td>
                                                    <?= extension_loaded('openssl') ? 'Enabled' : 'Not Enabled' ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php if (extension_loaded('openssl')) : ?>
                                                        ✅
                                                    <?php else : ?>
                                                        ❌
                                                        <?php $requirements = false; ?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>mbstring</td>
                                                <td>Enabled</td>
                                                <td>
                                                    <?= extension_loaded('mbstring') && function_exists('mb_get_info') ? 'Enabled' : 'Not Enabled' ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php if (extension_loaded('mbstring') && function_exists('mb_get_info')) : ?>
                                                        ✅
                                                    <?php else : ?>
                                                        ❌
                                                        <?php $requirements = false; ?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>MySQLi</td>
                                                <td>Enabled</td>
                                                <td>
                                                    <?= function_exists('mysqli_connect') ? 'Enabled' : 'Not Enabled' ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php if (function_exists('mysqli_connect')) : ?>
                                                        ✅
                                                    <?php else : ?>
                                                        ❌
                                                        <?php $requirements = false; ?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    <?php if ($requirements) : ?>
                                        <a href="#setup" class="navigator btn btn-block btn-primary">Next</a>
                                    <?php else : ?>
                                        <div class="alert alert-danger" role="alert">
                                            Please make sure all the requirements listed on this page are met before
                                            continuing!
                                        </div>
                                    <?php endif ?>
                                </div>
                            </section>

                            <section id="setup" style="display: none">
                                <h2 class="mb-4">Setup</h2>
                                <?php
                                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                $installation_url = preg_replace('/install\/$/', '', $actual_link);
                                ?>

                                <form id="setup_form" method="post" action="" role="form">

                                    <input type="text" class="form-control" id="app_url" name="app_url" value="<?= $installation_url ?>" placeholder="https://example.com/" required="required" hidden>

                                    <h3 class="">Database Details</h3>

                                    <div class="form-group">
                                        <label for="database_host">Host</label>
                                        <input type="text" class="form-control" id="database_host" name="database_host" value="localhost" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="database_name">Name</label>
                                        <input type="text" class="form-control" id="database_name" name="database_name" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="database_username">Username</label>
                                        <input type="text" class="form-control" id="database_username" name="database_username" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="database_password">Password</label>
                                        <input type="password" class="form-control" id="database_password" name="database_password">
                                    </div>

                                    <h3 class="mt-4">Application Details</h3>

                                    <div class="form-group">
                                        <label for="app_name">App Name</label>
                                        <input type="text" class="form-control" id="app_name" name="app_name" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="app_title">App Title</label>
                                        <input type="text" class="form-control" id="app_title" name="app_title" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="code_prefix">Code Prefix</label>
                                        <input type="text" class="form-control" id="code_prefix" name="code_prefix" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="admin_password">Admin Password</label>
                                        <input type="password" class="form-control" id="admin_password" name="admin_password" required="required">
                                    </div>

                                    <h3 class="mt-4">SMTP Details</h3>

                                    <div class="form-group">
                                        <label for="smtp_host">SMTP Host</label>
                                        <input type="text" class="form-control" id="smtp_host" name="smtp_host" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_port">SMTP Port</label>
                                        <input type="number" class="form-control" id="smtp_port" name="smtp_port" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_secure">SMTP Secure</label>
                                        <select class="form-control" id="smtp_secure" name="smtp_secure" required="required">
                                            <option value="ssl">SSL</option>
                                            <option value="tls">TLS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_auth">SMTP Auth</label>
                                        <select class="form-control" id="smtp_auth" name="smtp_auth" required="required">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_username">SMTP Username</label>
                                        <input type="text" class="form-control" id="smtp_username" name="smtp_username" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_password">SMTP Password</label>
                                        <input type="password" class="form-control" id="smtp_password" name="smtp_password" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_sender_email">SMTP Sender Email</label>
                                        <input type="email" class="form-control" id="smtp_sender_email" name="smtp_sender_email" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for="smtp_sender_name">SMTP Sender Name</label>
                                        <input type="text" class="form-control" id="smtp_sender_name" name="smtp_sender_name" required="required">
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-block btn-primary mt-4">Finish installation</button>
                                </form>
                            </section>


                            <section id="finish" style="display: none">
                                <h2 class="mb-4">Finish</h2>

                                <div class="alert alert-success">The installation process has been successfuly
                                    completed!</div>

                                <div class="table-responsive table-custom-container mt-4">
                                    <table class="table table-custom">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Installation Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="font-weight-bold">Admin Panel</td>
                                                <td><a href="<?= $installation_url ?>/admin"><?= $installation_url ?>/admin</a></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Password</td>
                                                <td>12345678</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <a href="../" class="navigator btn btn-block btn-primary mt-4">Close the installer</a>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>