<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <script src="https://unpkg.com/htmx.org@2.0.2"
        integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <h1>Welcome!</h1>
    <ul class="menu">
        <li><a class="btn btn-med btn-link" href="#pray-tab" hx-get="/pray.php" hx-target="#pray-tab">Pray</a></li>
        <li><a class="btn btn-med btn-link" href="#prayer-publish-tab" hx-get="/prayer-publish.php" hx-target="#prayer-publish-tab">Publish Prayer</a></li>
    </ul>

    <div id="pray-tab" class="tab-content">
        <p class="htmx-indicator">Result loading...</p>
    </div>

    <div id="prayer-publish-tab" class="tab-content">
        <p class="htmx-indicator">Result loading...</p>
    </div>
</body>

</html>