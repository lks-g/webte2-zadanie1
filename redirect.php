<?php

session_start();

require_once 'vendor/autoload.php';
require_once('config.php');

$client = new Google\Client();
$client->setAuthConfig('../../client_secret.json');

$redirect_uri = "https://site98.webte.fei.stuba.sk/z1-oh/redirect.php";
$client->setRedirectUri($redirect_uri);

$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        $oauth = new Google\Service\Oauth2($client);
        $account_info = $oauth->userinfo->get();
        $g_id = $account_info->id;
        $g_email = $account_info->email;
        $g_name = $account_info->givenName;
        $g_surname = $account_info->familyName;
        $g_fullname = $account_info->name;

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $g_email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            header('Location: restricted.php');
        } else {
            $stmt = $db->prepare("INSERT INTO users (full_name, email, login, password, 2fa_secret, created_at, google_login) VALUES (:full_name, :email, :login, :password, :2fa_secret, NOW(), :google_login)");
            $stmt->bindParam(":full_name", $g_fullname);
            $stmt->bindParam(":email", $g_email);
            $stmt->bindParam(":login", $g_id);
            $password = password_hash($g_id, PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $password);
            $fa = "None";
            $stmt->bindValue(":2fa_secret", $fa);
            $google_login = 1;
            $stmt->bindParam(":google_login", $google_login);
            $stmt->execute();
            $user_id = $db->lastInsertId();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = $g_fullname;
            $_SESSION['email'] = $g_email;
            header('Location: restricted.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $_SESSION['access_token'] = $token['access_token'];
    $_SESSION['id'] = $g_id;
    $_SESSION['name'] = $g_name;
    $_SESSION['surname'] = $g_surname;
    $_SESSION['fullname'] = $g_fullname;
}