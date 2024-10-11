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

    $query = "SELECT * FROM `kjm`.`prayers`";
    $where_clause = " WHERE 1 = 1";
    if (!empty($_GET["query-name"])) {
        $query_name = trim($_GET["query-name"]);
        $where_clause .= " AND CONCAT(`first_name`, `last_name`) LIKE '%$query_name%'";
    }

    if (!empty($_GET["query-county"])) {
        $query_county = trim($_GET["query-county"]);
        $where_clause .= " AND `county` = '$query_county'";
    }

    if (!empty($_GET["query-date-start"])) {
        $query_date_start = trim($_GET["query-date-start"]);
        $where_clause .= " AND `date` >= STR_TO_DATE('$query_date_start', '%Y-%m-%d')";
    }

    if (!empty($_GET["query-date-end"])) {
        $query_date_end = trim($_GET["query-date-end"]);
        $where_clause .= " AND `date` <= STR_TO_DATE('$query_date_end', '%Y-%m-%d')";
    }

    $query .= $where_clause . " ORDER BY `date` DESC";

    $page_index = 0;
    if (!empty($_GET['query-page-index'])) {
        $page_index = (int) trim($_GET["query-page-index"]);
    }

    $page_length = 10;
    $offset = $page_index * $page_length;
    $query .= " LIMIT " . $offset . "," . $page_length;

    $prayers = $db->query($query);

    $count_query = "SELECT COUNT(*) FROM `kjm`.`prayers`" . $where_clause;
    $count_result = $db->query($count_query);
    $count = $count_result->fetch_row()[0];
    $pages = ceil($count / $page_length);

    $db->close();
?>

<body>
    <dialog id="prayer-dialog">
        <details>
            <summary>Upload from image?</summary>
            <form id="prayer-image-form" hx-encoding='multipart/form-data' hx-post='/ocr.php' hx-target='#prayer' hx-swap="outerHTML">
                <input type='file' id='file' name='file' class='btn btn-secondary btn-input'>
                <input type='submit' class='btn btn-primary btn-input' value='Convert image to text' />
            </form>
        </details>
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
            <input type="submit" class="btn btn-primary btn-input" />
            <input value="Cancel" onclick="document.getElementById('prayer-dialog').close()" class="btn btn-secondary btn-input" />
        </form>
    </dialog>

    <form id="query-prayer-form"></form>
    <table id="prayer-table">
        <thead>
            <tr id="table-header">
                <th colspan="4">
                    <p>Prayers</p>
                </th>
            </tr>
            <tr id="column-headers">
                <th></th>
                <th>Name</th>
                <th>County</th>
                <th>Date</th>
            </tr>
            <tr id="query-inputs">
                <th><input value="🔎" type="submit" form="query-prayer-form" /></th>
                <th><input value="<?= !empty($_GET["query-name"]) ? $_GET["query-name"] : "" ?>" id="query-name" name="query-name" type="search" form="query-prayer-form" /></th>
                <th>
                    <select id="query-county" name="query-county" form="query-prayer-form">
                        <option></option>
                        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Boone") echo ("selected"); ?>>Boone</option>
                        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Campbell") echo ("selected"); ?>>Campbell</option>
                        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Kenton") echo ("selected"); ?>>Kenton</option>
                        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Grant") echo ("selected"); ?>>Grant</option>
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
            <?php foreach ($prayers as $prayer): ?>
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
                <th>

                </th>
                <th>
                    <label for="query-page-index">Page</label>
                    <select id="query-page-index" name="query-page-index" form="query-prayer-form" onchange="document.getElementById('query-prayer-form').submit()">
                        <?php for ($x = 0; $x < $pages; $x++): ?>
                            <option value="<?= $x ?>" <?php if ($x === $page_index) echo ("selected"); ?>><?= ($x + 1) ?></option>
                        <?php endfor ?>
                    </select>
                </th>
                <th colspan="2">
                    <input value="New prayer" onclick="document.getElementById('prayer-dialog').showModal()" class="btn btn-primary btn-input" type="button" />
                </th>
            </tr>
        </tfoot>
    </table>
</body>

</html>