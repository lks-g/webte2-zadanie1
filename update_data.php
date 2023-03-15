<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    // handle form submission for updating/creating a record
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $birth_day = $_POST['birth_day'];
        $birth_place = $_POST['birth_place'];
        $birth_country = $_POST['birth_country'];
        $death_day = $_POST['death_day'];
        $death_place = $_POST['death_place'];
        $death_country = $_POST['death_country'];
    
        // check if a record already exists with the given name and surname
        $query = "SELECT * FROM person WHERE name='$name' AND surname='$surname'";
        $stmt = $db->query($query);
        $person = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // update existing record or create new one
        if ($person) {
            $id = $person['id'];
            $query = "UPDATE person SET birth_day='$birth_day', birth_place='$birth_place', birth_country='$birth_country', death_day=NULL, death_place='$death_place', death_country='$death_country' WHERE id=$id";
        } else {
            $query = "INSERT INTO person (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) VALUES ('$name', '$surname', '$birth_day', '$birth_place', '$birth_country', ";
            if (!empty($death_day)) {
                $query .= "'$death_day', ";
            } else {
                $query .= "NULL, ";
            }
            $query .= "'$death_place', '$death_country')";
        }
        $db->query($query);    
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $id = $_POST['id'];
    
        try {
            $query = "DELETE FROM person WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Location: admin.php');
