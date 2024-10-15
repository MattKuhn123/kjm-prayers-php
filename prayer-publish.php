<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/prayer-publish.css">
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $db = mysqli_connect();
        $first_name = trim($_POST["first-name"]);
        $last_name = trim($_POST["last-name"]);
        $county = trim($_POST["county"]);
        $date = trim($_POST["date"]);
        $prayer = trim($_POST["prayer"]);

        $stmt = $db->prepare("INSERT INTO `kjm`.`prayers` (first_name, last_name, county, date, prayer) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $county, $date, $prayer);
        $stmt->execute();
        $stmt->close();
        $db->close();
        echo ("Published prayer!");
    } catch (Exception $e) {
        echo ("Error!");
    }
}
?>
<form id="prayer-publish" action="/prayer-publish.php" method="POST">
    <fieldset>
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
        <input required id="date" name="date" type="date" value="<?php echo date('Y-m-d'); ?>"/>
    </fieldset>
    
    <fieldset class="centered>
        <label for="file">You may take a picture of the prayer to pre-populate it below.</label>
        <input value="" type="file" id="file" name="file" class="btn btn-secondary btn-slim">
        <input value="Convert" type="button" hx-encoding="multipart/form-data" hx-indicator="#loading" hx-post="/ocr.php" hx-target="#prayer" hx-swap="textContent" class="btn btn-secondary btn-slim">
            <span class="htmx-indicator" id="loading">⚒ <i>(Working)</i> ⚒</span>
        </input>
        <label for="prayer">Prayer</label>
        <textarea required id="prayer" name="prayer" rows="6"></textarea>
    </fieldset>

    <fieldset class="centered">
        <input type="submit" class="btn btn-primary btn-slim" />
        <a href="/index.php" class="btn btn-secondary btn-slim">Cancel</a>
    </fieldset>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <span id="result"></span>
<?php endif ?>

</html>