<?php
require_once('config.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT person.name, person.surname, person.birth_day, person.birth_place, person.birth_country, person.death_day, person.death_place, 
                     person.death_country, game.year, game.city, game.country, game.type, placement.discipline, placement.placing FROM person 
              INNER JOIN placement ON person.id = placement.person_id
              INNER JOIN game ON placement.game_id = game.id
              WHERE person.id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) === 0) {
        header('Location: index.php');
        exit();
    }
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
    <title>Olympic Games - <?= $results[0]['name'] . ' ' . $results[0]['surname'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="index.php">Slovenskí olympionici</a>
        <div>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="login.php">Admin Panel</a>
        </div>
    </nav>

    <div id="tables">
        <h1><?= $results[0]['name'] . ' ' . $results[0]['surname'] ?></h1>

        <table class="table" id="athlete-table">
            <thead>
                <tr>
                    <td>Meno</td>
                    <td>Priezvisko</td>
                    <td>Narodený/á</td>
                    <td>Mesto narodenia</td>
                    <td>Krajina narodenia</td>
                    <td>Deň úmrtia</td>
                    <td>Miesto úmrtia</td>
                    <td>Krajina úmrtia</td>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)) : ?>
                    <?php $result = reset($results); ?>
                    <tr>
                        <td><?= $result["name"] ?></td>
                        <td><?= $result["surname"] ?></td>
                        <td><?= $result["birth_day"] ?></td>
                        <td><?= $result["birth_place"] ?></td>
                        <td><?= $result["birth_country"] ?></td>
                        <td><?= $result["death_day"] ?></td>
                        <td><?= $result["death_place"] ?></td>
                        <td><?= $result["death_country"] ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h1>Úspechy</h1>
        <table class="table" id="athlete-table">
            <thead>
                <tr>
                    <td>Rok</td>
                    <td>Mesto</td>
                    <td>Krajina</td>
                    <td>Typ</td>
                    <td>Umiestenie</td>
                    <td>Disciplína</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) : ?>
                    <tr>
                        <td><?= $result["year"] ?></td>
                        <td><?= $result["city"] ?></td>
                        <td><?= $result["country"] ?></td>
                        <td><?= $result["type"] ?></td>
                        <td><?= $result["placing"] ?></td>
                        <td><?= $result["discipline"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <a href="restricted.php" class="btn btn-primary">Späť</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./DataTables/datatables.min.js"></script>
    <script src="./scripts/script.js"></script>
</body>

</html>