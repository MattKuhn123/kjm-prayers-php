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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // …
}

$prayers = array(
    array("first_name" => "Matt", "last_name" => "Kuhn", "county" => "Kenton", "date" => date_create("2024-01-20")),
    array("first_name" => "Joe", "last_name" => "Smith", "county" => "Campbell", "date" => date_create("2024-01-22")),
    array("first_name" => "Ricky", "last_name" => "Sanchez", "county" => "Boone", "date" => date_create("2024-01-24")),
    array("first_name" => "Bobby", "last_name" => "Rodriguez", "county" => "Grant", "date" => date_create("2024-01-26")),
);
?>

<body>
    <table id="prayer-table">
        <thead>
            <tr>
                <th></th>
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
                    <td><?= date_format($prayer["date"], "Y/m/d") ?></td>
                </tr>
                <tr>
                    <td colspan="3">This is my prayer, This is my prayer, This is my prayer, This is my prayer!!!!</td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <form action='/index.php' method="post">
        <div class='form-control'>
            <label for='first-name'>First Name</label>
            <input required id='first-name' name='first-name' type='text' />
        </div>
        <div class='form-control'>
            <label for='last-name'>Last Name</label>
            <input required id='last-name' name='last-name' type='text' />
        </div>
        <div class='form-control'>
            <label for='county'>County</label>
            <select id='county' name='county'>
                <option value='Boone'>Boone</option>
                <option value='Campbell'>Campbell</option>
                <option value='Kenton'>Kenton</option>
                <option value='Grant'>Grant</option>
            </select>
        </div>
        <div class='form-control'>
            <label for='date'>Date</label>
            <input required id='date' name='date' type='date' />
        </div>
        <div class='form-control'>
            <label for='prayer'>Prayer</label>
            <textarea required id='prayer-text' name='prayer-text' rows='5'></textarea>
        </div>
        <input type='submit' class='btn btn-primary' />
        <span></span>
    </form>


</body>

</html>