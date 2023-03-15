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

    $query = "SELECT * FROM person";
    $stmt = $db->query($query);
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Admin panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="login.php">Vitaj <?php echo $fullname ?></a>
        <div>
            <a href="logout.php">Odhlasiť</a>
            <a href="restricted.php">Hlavná stránka</a>
        </div>
    </nav>

    <div id="main">
        <div class="container-md">
            <h1>Admin panel</h1>
            <h2>Pridaj sportovca</h2>
            <form method="post" action="update_data.php" onsubmit="return validateForm()">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"><br>
                <span id="name-error" class="error-message"></span><br>

                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname"><br>
                <span id="surname-error" class="error-message"></span><br>

                <label for="birth_day">Birth Day:</label>
                <input type="date" id="birth_day" name="birth_day"><br>
                <span id="birth_day-error" class="error-message"></span><br>

                <label for="birth_place">Birth Place:</label>
                <input type="text" id="birth_place" name="birth_place"><br>
                <span id="birth_place-error" class="error-message"></span><br>

                <label for="birth_country">Birth Country:</label>
                <input type="text" id="birth_country" name="birth_country"><br>
                <span id="birth_country-error" class="error-message"></span><br>

                <label for="death_day">Death Day:</label>
                <input type="date" id="death_day" name="death_day"><br>
                <span id="death_day-error" class="error-message"></span><br>

                <label for="death_place">Death Place:</label>
                <input type="text" id="death_place" name="death_place"><br>
                <span id="death_place-error" class="error-message"></span><br>

                <label for="death_country">Death Country:</label>
                <input type="text" id="death_country" name="death_country"><br>
                <span id="death_country-error" class="error-message"></span><br>

                <button type="submit">Save</button>
            </form>

            <form action="#" method="post">
                <select name="person_id">
                    <?php
                    foreach ($persons as $person) {
                        echo '<option value="' . $person['id'] . '">' . $person['name'] . ' ' . $person['surname'] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Edit</button>

                <table class="table" id="edit-table">
                    <thead>
                        <tr>
                            <td>Meno a priezvisko</td>
                            <td>Narodený/á</td>
                            <td>Mesto narodenia</td>
                            <td>Krajina narodenia</td>
                            <td>Deň úmrtia</td>
                            <td>Miesto úmrtia</td>
                            <td>Krajina úmrtia</td>
                            <td>Operácia</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($persons as $person) {
                            $date = new DateTimeImmutable($person["birth_day"]);

                            echo "<tr><td><a href='editPerson.php?id=" . $person["id"] . "'>" .
                                $person["name"] . ' ' . $person["surname"] . "</a>" .
                                "</td><td>" . $date->format("d.m.Y") .
                                "</td><td>" . $person["birth_place"] .
                                "</td><td>" . $person["birth_country"] .
                                "</td><td>" . $person["death_day"] .
                                "</td><td>" . $person["death_place"] .
                                "</td><td>" . $person["death_country"] .
                                "</td><td><a href='deletePerson.php?id=" . $person["id"] . "' class='btn btn-danger'>Vymazať</a></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="./DataTables/datatables.min.js"></script>
    <script src="./scripts/script.js"></script>
</body>

</html>