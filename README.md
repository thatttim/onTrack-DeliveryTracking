# onTrack

onTrack is a minimalistic order tracking application designed to provide users with an easy way to track their packages. This PHP-based application offers a simple interface for both users and administrators to manage and view package tracking information.

[# Demo](https://ontrack.framework.ge)

Use those tracking numbers for testing: ON66R859U6V4S81; ON66K182N8O6L14; ON66D415G1H8E47

## Features

- **User Interface**
  - Track your orders using unique tracking codes.
  - View tracking history with status updates.
  - Minimalistic design for a seamless user experience.

- **Admin Panel**
  - Login with password protection.
  - Manage tracking statuses and update order information.
  - Access to administrative functions through a dedicated panel.

## Installation Instructions

Follow these steps to install and configure the onTrack delivery tracking website script:

1. **Upload Files**
   - Upload all files from the project folder, including the `.htaccess` file, to your hosting server or pc using an FTP client or your hosting control panel's file manager.

2. **Create Database**
   - Create a new MySQL database using your hosting control panel or phpMyAdmin. You can name the database anything you like. Make note of the database name, username, and password.

3. **Visit Installation URL**
   - Navigate to the URL where you uploaded the onTrack files. You will be redirected to the installation setup form.

4. **Fill Installation Form**
   - Fill in the necessary information in the installation form.

5. **Complete Installation**
   - After submitting the form, the script will automatically configure the database and settings. Once completed, you can log in to the admin panel and start using onTrack.

## Requirements

- PHP 7.4 or higher
- MySQL database
- Apache server with mod_rewrite enabled

## Usage

- **Tracking an Order:**
  - Enter your unique tracking code on the homepage to view the status of your package.

- **Admin Panel:**
  - Log in using the admin password specified in the `config.php`.
  - Update tracking statuses and manage orders.

## About

This project is a free demo provided by Framework LLC. Feel free to use it for your needs.

## License

This project is open-source and available under the [MIT License](LICENSE).
