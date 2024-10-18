<?php
require './authentication.php';

$is_logged_in = is_logged_in_cookies();

if (!$is_logged_in) {
    header("Location: /login-email.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>
</head>


<body class="centered">
    <form class="my-form">
        <fieldset class="my-fieldset centered">
            <p>Welcome to the KJM prayer board!</p>
        </fieldset>
        <fieldset class="my-fieldset actions">
            <a class="btn btn-primary" href="/prayer-search.php">Pray</a>
            <a class="btn btn-primary" href="/prayer-publish.php">Publish</a>
        </fieldset>
    </form>
</body>

</html>