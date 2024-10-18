<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/login-email.css">
</head>

<?php

require './authentication.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["code"]) && isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $is_logged_in = is_logged_in_post();

        if ($is_logged_in) {
            login_post_to_cookies();
            header("Location: /index.php");
            exit();
        }
    }
}
?>

<body>
    <form class="my-form" method="post" action="login-code.php">
        <fieldset class="my-fieldset">
            <p>Code</p>
        </fieldset>
        <fieldset class="my-fieldset">
            <label for="email">Email</label>
            <input required class="my-input" type="email" name="email" id="email" value="<?= isset($email) ? $email : "" ?>" />
        </fieldset>
        <fieldset class="my-fieldset">
            <label for="code">Paste code:</label>
            <input required class="my-input" name="code" id="code" />
        </fieldset>
        <fieldset class="my-fieldset">
            <input type="submit" value="Login" class="btn btn-primary my-input" />
        </fieldset>
    </form>
</body>

</html>