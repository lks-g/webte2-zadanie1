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

    $query = "SELECT person.name, person.surname, person.birth_day, person.birth_place, person.birth_country, person.death_day, person.death_place, person.death_country
              FROM person WHERE person.id = :id";
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
<html lang="sk">

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
    <header>
        <nav class="navbar" id="navbar">
            <?php if ($is_logged_in) : ?>
                <a href="admin.php" class="ms-auto" style="color: green;">Admin Panel</a>
            <?php else : ?>
                <a href="admin.php" class="ms-auto" style="color: gray;">Admin Panel</a>
                <a href="login.php" class="ms-3" style="color: gray;">Login</a>
                <a href="register.php" style="color: gray;">Register</a>
            <?php endif; ?>
        </nav>
    </header>

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
                <?php foreach ($results as $result) : ?>
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
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <a href="index.php" class="btn btn-primary">Späť na domovskú stránku</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./DataTables/datatables.min.js"></script>
    <script src="./scripts/script.js"></script>
</body>

</html>