<?php
require_once('./conx.php');

if (!empty($_POST["username"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?);";
    $stmt = mysqli_prepare($link, $sql);
    $stmt->bind_param("ss", $username, $password);
    $success = $stmt->execute();

    if ($success) {
        $user_id = $stmt->insert_id;

        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $user_id;

        header('Location: /');
        die;
    } else $error = $stmt->errno;
}

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
                    <input type="text" class="<?= $error === 1062 ? 'invalido' : '' ?>" name="username" id="username" placeholder="Nombre de usuario" value="<?= @$username ?>" oninput="clearUsername()" onchange="checkUsername(this)" autofocus required>
                    <? if (@$error === 1062) : ?>
                        <div class="message invalido-div" id="user-div">
                            <p>Nombre de usuario en uso. Elige otro.</p>
                        </div>
                    <? endif; ?>
                </div>
                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" oninput="checkPassword(this)" required>
                </div>
                <div class="message">
                    <p>La contraseña debe tener:</p>
                    <ul>
                        <li id="caracteres">Mínimo 8 carácteres</li>
                        <li id="mayuscula">Mínimo 1 mayúscula</li>
                        <li id="numero">Mínimo 1 número</li>
                    </ul>
                </div>
                <button type="submit" disabled>Crear nueva cuenta</button>
                <a href="/entrar">Ya tengo cuenta</a>
            </section>
        </form>
    </main>
    <script src="/js/registro.js"></script>
</body>

</html>