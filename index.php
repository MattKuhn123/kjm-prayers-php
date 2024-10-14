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
    <div id="replace-me" hx-get="/menu.php" hx-trigger="load" hx-swap="outerHTML">
        <p class="htmx-indicator">Result loading...</p>
    </div>
    <footer>
        
    </footer>
</body>
</html>