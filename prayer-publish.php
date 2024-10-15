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
            echo("Published prayer!");
        } catch (Exception $e) {
            echo("Error!");
        }
    }
?>
<link rel="stylesheet" href="/prayer-publish.css">
<?php if ($_SERVER["REQUEST_METHOD"] === "GET"): ?>
    <form id="prayer-form" hx-post="/prayer-publish.php" hx-target="#result">
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
        <label for="file">Convert image to text</label>
        <input value="" type="file" id="file" name="file" class="btn btn-secondary btn-slim">
        <button type="button" hx-encoding="multipart/form-data" hx-indicator="#loading" hx-post="/ocr.php" hx-target="#prayer" hx-swap="outerHTML" class="btn btn-secondary btn-slim">
            Convert
            <span class="htmx-indicator" id="loading">⚒ <i>(Working)</i> ⚒</span>
        </button>
        <label for="prayer">Prayer</label>
        <textarea required id="prayer" name="prayer" rows="6"></textarea>
        <input type="submit" class="btn btn-primary btn-slim" />
        <input value="Cancel" onclick="document.getElementById('prayer-dialog').close()" class="btn btn-secondary btn-slim" />
    </form>
    <span id="result"></span>
<?php endif ?>