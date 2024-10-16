<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/index.css">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>
</head>

<body class="centered">
    <form class="my-form">
        <fieldset class="my-fieldset">
            <p>Login</p>
        </fieldset>
        <fieldset class="my-fieldset">
            <label for="email">Email</label>
            <input class="my-input" type="email" name="email" id="email" />
            <p id="result"></p>
            <button class="btn btn-primary my-input" hx-post="mail.php" hx-target="#result" hx-indicator="#loading">
                Email
                <span class="htmx-indicator" id="loading">⚒ <i>(Working)</i> ⚒</span>
            </button>
        </fieldset>
    </form>

    <form class="my-form">
        <fieldset class="my-fieldset">
            <p>Welcome to the KJM prayer board!</p>
        </fieldset>
        <fieldset class="my-fieldset actions">
            <a class="btn btn-secondary" href="/prayer-search.php">Pray</a>
            <a class="btn btn-secondary" href="/prayer-publish.php">Publish</a>
        </fieldset>
    </form>
</body>

</html>