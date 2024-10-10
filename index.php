<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <script src="https://unpkg.com/htmx.org@2.0.2" integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/styles.css">
</head>

<?php
$prayers = array(
    array("first_name" => "Matt", "last_name" => "Kuhn", "county" => "Kenton", "date" => date_create("2024-01-20")),
    array("first_name" => "Joe", "last_name" => "Smith", "county" => "Campbell", "date" => date_create("2024-01-22")),
);
?>

<body>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>County</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prayers as $prayer) : ?>
                <tr>
                    <td><?= htmlspecialchars($prayer["first_name"] ." " . $prayer["last_name"]) ?></td>
                    <td><?= htmlspecialchars($prayer["county"]) ?></td>
                    <td><?= date_format($prayer["date"], "Y/m/d") ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>