<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/prayer-results.css">
</head>

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

<body>
    <?php if ($prayers->num_rows == 0): ?>
        <form class="centered my-form">
            <fieldset class="my-fieldset">
                <p>We couldn't find the prayer you were looking for!</p>
                <a href="/prayer-search.php" class="btn btn-primary">Try again</a>
                <a href="/index.php" class="btn btn-secondary">Home</a>
            </fieldset>
        </form>
    <?php endif ?>

    <?php if ($prayers->num_rows > 0): ?>
        <div class="centered gap">
            <?php foreach ($prayers as $prayer): ?>
                <fieldset class="my-fieldset">
                    <header class="smaller-text">
                        <p>
                            <span><?= htmlspecialchars($prayer["first_name"]) . " " . htmlspecialchars($prayer["last_name"]) ?></span>
                            <span class="right"><time datetime="<?= $prayer["date"] ?>"><?= $prayer["date"] ?></time></span>
                        </p>
                        <p>
                            <span colspan="2"><?= htmlspecialchars($prayer["county"]) ?></span>
                        </p>
                    </header>
                    <blockquote>
                        <q>
                            <?= htmlspecialchars($prayer["prayer"]) ?>
                        </q>
                    </blockquote>
                    <section class="actions">
                        <button class="btn btn-secondary smaller-text my-input">🙏</button>
                        <button class="btn btn-secondary smaller-text my-input">🤲</button>
                        <button class="btn btn-secondary smaller-text my-input">💒</button>
                    </section>
                </fieldset>
            <?php endforeach ?>
            <a href="/index.php" class="btn btn-secondary">Finished</a>
        </div>
    <?php endif ?>
</body>

</html>