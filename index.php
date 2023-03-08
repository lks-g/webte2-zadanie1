<?php

require_once('config.php');
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT person.name, game.year, game.city, game.country, game.type, placement.discipline 
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-md">
        <h1>Olympic Games</h1>
        <table class="table">
            <thead>
                <tr>
                    <td>Meno</td>
                    <td>Rok</td>
                    <td>Mesto</td>
                    <td>Krajina</td>
                    <td>Typ</td>
                    <td>Disciplína</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result) {
                    echo "<tr><td>" . $result["name"] .
                        "</td><td>" . $result["year"] .
                        "</td><td>" . $result["city"] .
                        "</td><td>" . $result["country"] .
                        "</td><td>" . $result["type"] .
                        "</td><td>" . $result["discipline"] . 
                        "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>