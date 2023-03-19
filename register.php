<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympic Games - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="index.php">Slovenskí olympionici</a>
        <div>
            <a href="#">Register</a>
            <a href="login.php">Login</a>
            <a href="#">Admin Panel</a>
        </div>
    </nav>
    </div>

    <div id="core">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="firstname">
                Meno:
                <input type="text" name="firstname" value="" id="firstname" placeholder="napr. Jonatan" required>
            </label>

            <label for="lastname">
                Priezvisko:
                <input type="text" name="lastname" value="" id="lastname" placeholder="napr. Petrzlen" required>
            </label>

            <br>

            <label for="email">
                E-mail:
                <input type="email" name="email" value="" id="email" placeholder="napr. jpetrzlen@example.com" required>
            </label>

            <label for="login">
                Login:
                <input type="text" name="login" value="" id="login" placeholder="napr. jperasin" required">
            </label>

            <br>

            <label for="password">
                Heslo:
                <input type="password" name="password" value="" id="password" required>
            </label>

            <button type="submit">Vytvorit konto</button>

            <?php
            if (!empty($errmsg)) {
                echo $errmsg;
            }
            if (isset($qrcode)) {
                $message = '<p>Naskenujte QR kod do aplikacie Authenticator pre 2FA: <br><img src="' . $qrcode . '" alt="qr kod pre aplikaciu authenticator"></p>';

                echo $message;
                echo '<p>Môžte prihlásiť <a href="login.php" role="button">Login</a></p>';
            }
            ?>

        </form>
        <p>Máte vytvorené konto ? <a href="login.php">Prihláste sa tu.</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./DataTables/datatables.min.js"></script>
    <script src="./scripts/script.js"></script>
</body>

</html>