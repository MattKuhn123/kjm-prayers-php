<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
</head>

<?php
$db = mysqli_connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first-name"]);
    $last_name = trim($_POST["last-name"]);
    $county = trim($_POST["county"]);
    $date = trim($_POST["date"]);
    $prayer = trim($_POST["prayer"]);

    $stmt = $db->prepare("INSERT INTO `kjm`.`prayers` (first_name, last_name, county, date, prayer) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $county, $date, $prayer);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM `kjm`.`prayers` WHERE 1=1";
if (!empty($_GET["query-name"])) {
    $query_name = trim($_GET["query-name"]);
    $sql .= " AND CONCAT(`first_name`, `last_name`) LIKE '%$query_name%'";
}

if (!empty($_GET["query-county"])) {
    $query_county = trim($_GET["query-county"]);
    $sql .= " AND `county` = '$query_county'";
}

if (!empty($_GET["query-date-start"])) {
    $query_date_start = trim($_GET["query-date-start"]);
    $sql .= " AND `date` >= STR_TO_DATE('$query_date_start', '%Y-%m-%d')";
}

if (!empty($_GET["query-date-end"])) {
    $query_date_end = trim($_GET["query-date-end"]);
    $sql .= " AND `date` <= STR_TO_DATE('$query_date_end', '%Y-%m-%d')";
}

$prayers = $db->query($sql);
$db->close();
?>

<body>
    <dialog id="prayer-dialog">
        <form id="prayer-form" action="/" method="post">
            <label for="first-name">First Name</label>
            <input required id="first-name" name="first-name" type="text" />
            <label for="last-name">Last Name</label>
            <input required id="last-name" name="last-name" type="text" />
            <label for="county">County</label>
            <select id="county" name="county">
                <option>Boone</option>
                <option>Campbell</option>
                <option>Kenton</option>
                <option>Grant</option>
            </select>
            <label for="date">Date</label>
            <input required id="date" name="date" type="date" />
            <label for="prayer">Prayer</label>
            <textarea required id="prayer" name="prayer" rows="5"></textarea>
            <input type="submit" class="btn btn-primary" />
            <input value="Cancel" onclick="document.getElementById('prayer-dialog').close()" class="btn btn-secondary" />
        </form>
    </dialog>

    <form id="query-prayer-form"></form>
    <table id="prayer-table">
        <thead>
            <tr>
                <th colspan="4">
                    <p>Prayers</p>
                </th>
            </tr>
            <tr>
                <th>⛪</th>
                <th>Name</th>
                <th>County</th>
                <th>Date</th>
            </tr>
            <tr>
                <th><input value="🔎" type="submit" form="query-prayer-form"/></th>
                <th><input value="<?= !empty($_GET["query-name"]) ? $_GET["query-name"] : "" ?>" id="query-name" name="query-name" type="text" form="query-prayer-form" /></th>
                <th>
                    <select id="query-county" name="query-county" form="query-prayer-form">
                        <option></option>
                        <option <?php if(!empty($_GET["query-county"]) && $_GET["query-county"] === "Boone") echo("selected"); ?>>Boone</option>
                        <option <?php if(!empty($_GET["query-county"]) && $_GET["query-county"] === "Campbell") echo("selected"); ?>>Campbell</option>
                        <option <?php if(!empty($_GET["query-county"]) && $_GET["query-county"] === "Kenton") echo("selected"); ?>>Kenton</option>
                        <option <?php if(!empty($_GET["query-county"]) && $_GET["query-county"] === "Grant") echo("selected"); ?>>Grant</option>
                    </select>
                </th>
                <th>
                    <input value="<?= !empty($_GET["query-date-start"]) ? $_GET["query-date-start"] : "" ?>" id="query-date-start" name="query-date-start" type="date" form="query-prayer-form" />
                    -
                    <input value="<?= !empty($_GET["query-date-end"]) ? $_GET["query-date-end"] : "" ?>" id="query-date-end" name="query-date-end" type="date" form="query-prayer-form" />
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prayers as $prayer) : ?>
                <tr>
                    <td rowspan="2"></td>
                    <td><?= htmlspecialchars($prayer["first_name"] . " " . $prayer["last_name"]) ?></td>
                    <td><?= htmlspecialchars($prayer["county"]) ?></td>
                    <td><time datetime="<?= $prayer["date"] ?>"><?= $prayer["date"] ?></time></td>
                </tr>
                <tr>
                    <td colspan="3"><?= htmlspecialchars($prayer["prayer"]) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">
                    <input value="New prayer" onclick="document.getElementById('prayer-dialog').showModal()" class="btn btn-primary" type="button" />
                </th>
            </tr>
        </tfoot>
    </table>
</body>

</html>