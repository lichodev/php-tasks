<?php
require_once("conx.php");

do {
    if (empty($_POST["username"])) break;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT user_id, username, password FROM users WHERE username=?;";
    $stmt = mysqli_prepare($link, $sql);
    $stmt->bind_param("s", $username);
    $success = $stmt->execute();
    if (!$success) break;

    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    if ($result === null) {
        $error = "No existe ese usuario.";
        $errorCode = 1;
        break;
    }

    $correct_password = create_user_session($result, $password);
    if (!$correct_password) {
        $error = "La contraseña es incorrecta.";
        $errorCode = 2;
        break;
    }

    header("Location: /");
    die;
} while (false);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <? include_once("_head.php"); ?>
    <title>Mis tareas</title>
</head>

<body>
    <main class="full-size">
        <form method="POST" class="page-form">
            <section>
                <div>
                    <label for="username">Nombre de usuario</label>
                    <input type="text" name="username" id="username" placeholder="Nombre de usuario" value="<?= @$_POST["username"] ?>" oninput="clearUsername()" autofocus required>
                    <? if (@$errorCode === 1) : ?>
                        <div class="message invalido-div" id="user-div">
                            <?= $error ?>
                        </div>
                    <? endif; ?>
                </div>
                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" oninput="clearPassword()" required>
                    <? if (@$errorCode === 2) : ?>
                        <div class="message invalido-div" id="password-div">
                            <?= $error ?>
                        </div>
                    <? endif; ?>
                </div>
                <button type="submit">Entrar</button>
                <a href="/registro">Crear una cuenta</a>
            </section>
        </form>
    </main>
    <script src="/js/registro.js"></script>
</body>

</html>