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
$prayers = $db->query($sql);
$db->close();
?>

<body>
    <dialog>
        <form id="prayer-form" action="/" method="post">
            <label for="first-name">First Name</label>
            <input required id="first-name" name="first-name" type="text" />

            <label for="last-name">Last Name</label>
            <input required id="last-name" name="last-name" type="text" />

            <label for="county">County</label>
            <select id="county" name="county">
                <option value="Boone">Boone</option>
                <option value="Campbell">Campbell</option>
                <option value="Kenton">Kenton</option>
                <option value="Grant">Grant</option>
            </select>

            <label for="date">Date</label>
            <input required id="date" name="date" type="date" />

            <label for="prayer">Prayer</label>
            <textarea required id="prayer" name="prayer" rows="5"></textarea>

            <input type="submit" class="btn btn-primary" />
            <input
                value="Cancel"
                onclick="document.getElementsByTagName('dialog')[0].close()"
                class="btn btn-secondary" />
        </form>
    </dialog>

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
        </thead>
        <tbody>
            <?php foreach ($prayers as $prayer) : ?>
                <tr>
                    <td rowspan="2">🙏</td>
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
                    <button
                        class="btn btn-primary"
                        onclick="document.getElementsByTagName('dialog')[0].showModal()">
                        New prayer
                    </button>
                </th>
            </tr>
        </tfoot>
    </table>

</body>

</html>