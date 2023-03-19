<?php

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olympic Games - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="index.php">Slovenskí olympionici</a>
        <div>
            <a href="register.php">Register</a>
            <a href="#">Login</a>
        </div>
    </nav>

    <?php
    echo '<div class="login">';
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        echo '<h3>Ahoj ' . $_SESSION['name'] . '</h3>';
        echo '<p>Si prihlaseny pod: ' . $_SESSION['email'] . '</p>';
        echo '<a href="logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Odhlas ma</a></p>';
    } else {

        echo '<h3>Nie si prihlaseny</h3>';
        echo '<a class="btn btn-secondary btn-lg active" role="button" aria-pressed="true" href="' . filter_var($auth_url, FILTER_SANITIZE_URL) . '">Google prihlasenie</a>';
        echo '<br>Nemáš učet <a id="link" href="register.php">Zaregistuj sa</a>';
    }
    echo '</div>';
    ?>
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>