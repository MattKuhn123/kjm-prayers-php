<?php
    $db = mysqli_connect();

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
<link rel="stylesheet" href="/prayer-results.css">
<table id="prayer-table">
    <thead>
        <tr id="column-headers">
            <th></th>
            <th>Name</th>
            <th>County</th>
            <th>Date</th>
        </tr>
        <tr id="query-inputs">

        </tr>
    </thead>
    <tbody>
        <?php foreach ($prayers as $prayer): ?>
            <tr>
                <td rowspan="2"><input value="🙏" type="button" /></td>
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
                <label for="query-page-index">Page</label>
                <select id="query-page-index" name="query-page-index" onchange="document.getElementById('query-prayer-form').submit()">
                    <?php for ($x = 0; $x < $pages; $x++): ?>
                        <option value="<?= $x ?>" <?php if ($x === $page_index) echo ("selected"); ?>><?= ($x + 1) ?></option>
                    <?php endfor ?>
                </select>
            </th>
        </tr>
    </tfoot>
</table>