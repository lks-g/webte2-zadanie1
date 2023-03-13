<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig('../../client_secret.json');

$redirect_uri = "https://site98.webte.fei.stuba.sk/z1-oh/redirect.php";
$client->setRedirectUri($redirect_uri);

$client->addScope("email");
$client->addScope("profile");

$auth_url = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olympic Games - Login</title>

    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="index.php">Slovenský olympionici</a>
        <div>
            <a href="register.php">Register</a>
            <a href="#">Login</a>
        </div>
    </nav>

    <div>
        <?php
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            echo '<h3>Vitaj ' . $_SESSION['name'] . '</h3>';
            echo '<p>Si prihlaseny ako: ' . $_SESSION['email'] . '</p>';
            echo '<p><a role="button" href="restricted.php">Zabezpecena stranka</a>';
            echo '<a role="button" class="secondary" href="logout.php">Odhlas ma</a></p>';
        } else {
            echo '<h3>Nie si prihlaseny</h3>';
            echo '<a role="button" href="' . filter_var($auth_url, FILTER_SANITIZE_URL) . '">Google prihlasenie</a>';
        }
        ?>
    </div>
</body>

</html>