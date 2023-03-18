<?php

require_once('config.php');

session_start();

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
    $fullname = $_SESSION['fullname'];
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];
} else {
    header('Location: index.php');
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT person.id, person.name, person.surname, game.year, game.city, game.country, game.type, placement.discipline, placement.placing
              FROM person 
              INNER JOIN placement ON person.id = placement.person_id
              INNER JOIN game ON placement.game_id = game.id";
    $stmt = $db->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympic Games</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body id="admin">
    <nav class="navbar" id="navbar">
        <a href="login.php">Vitaj <?php echo $fullname ?></a>
        <div>
            <a href="logout.php">Odhlasiť</a>
            <a href="admin.php">Admin Panel</a>
            <a href="login.php">Profil</a>
        </div>
    </nav>

    <div id="tables">
        <h2>Zoznam všetkých olympionikov</h2>
        <table class="table" id="olympic-table">
            <thead>
                <tr>
                    <td>Meno a priezvisko</td>
                    <td>Rok</td>
                    <td>Mesto</td>
                    <td>Krajina</td>
                    <td>Umiestenie</td>
                    <td>Typ</td>
                    <td>Disciplína</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result) {
                    echo "<tr><td><a href='athlete.php?id=" . $result["id"] . "'>" . $result["name"] . ' ' . $result["surname"] . "</a>" .
                        "</td><td>" . $result["year"] .
                        "</td><td>" . $result["city"] .
                        "</td><td>" . $result["country"] .
                        "</td><td>" . $result["placing"] .
                        "</td><td>" . $result["type"] .
                        "</td><td>" . $result["discipline"] .
                        "</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>10 najlepších olympionistov podľa počtu medailí</h2>
        <table class="table" id="best-table">
            <thead>
                <tr>
                    <td>Meno a priezvisko</td>
                    <td>Počet medailí</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT person.id, person.name, person.surname, COUNT(*) AS gold_medals
                  FROM person 
                  INNER JOIN placement ON person.id = placement.person_id AND placement.placing = 1
                  INNER JOIN game ON placement.game_id = game.id
                  GROUP BY person.id, person.name, person.surname
                  ORDER BY gold_medals DESC
                  LIMIT 10";

                $stmt = $db->query($query);
                $results_top = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results_top  as $result) {
                    echo "<tr><td><a href='athlete.php?id=" . $result["id"] . "'>" . $result["name"] . ' ' . $result["surname"] . "</a>" .
                        "</td><td>" . $result["gold_medals"] .
                        "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./DataTables/datatables.min.js"></script>
    <script src="./scripts/script.js"></script>
</body>

</html>