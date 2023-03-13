<?php

session_start();

// Uvolni vsetky session premenne.
session_unset();

// Vymaz vsetky data zo session.
session_destroy();

// Ak nechcem zobrazovat obsah, presmeruj pouzivatela na hlavnu stranku.
// header('location:index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olympic Games - Logout</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
        <h1>Boli ste uspesne odhlaseni</h1>
        <a href="index.php">Vrátiť sa na hlavnú stránku</a>
</body>
</html>