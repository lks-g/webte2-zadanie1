<?php

require_once('config.php');

session_start();

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $fullname = $_SESSION['fullname'];
} else {
    header('Location: index.php');
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET["id"];
    $sql = "DELETE FROM person WHERE id=$id";

    if ($db->query($sql) === TRUE) {
        echo "Záznam o osobe s ID $id bol úspešne odstránený.";
    } else {
        echo "Chyba: " . $conn->error;
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Location: admin.php');