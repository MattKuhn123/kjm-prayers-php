<?php
require './authentication.php';

$is_logged_in = is_logged_in_cookies();

if (!$is_logged_in) {
  header("Location: /login-email.php");
  exit();
}
?>

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
  $success = false;

  $db = mysqli_connect();

  try {
    $first_name = trim($_POST["first-name"]);
    $last_name = trim($_POST["last-name"]);
    $county = trim($_POST["county"]);
    $date = trim($_POST["date"]);
    $prayer = trim($_POST["prayer"]);

    $stmt = $db->prepare("INSERT INTO `kjm`.`prayers` (first_name, last_name, county, date, prayer) VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $county, $date, $prayer);
    $stmt->execute();
    $stmt->close();
    $success = true;
  } catch (Exception $e) {
    echo ("Error!");
  } finally {
    $db->close();
  }
}
?>

<body>
  <form class="my-form" id="prayer-publish" action="/prayer-publish.php" method="POST">
    <fieldset class="my-fieldset centered">
      <p>New prayer</p>
    </fieldset>

    <fieldset class="my-fieldset">
      <label for="first-name">First Name</label>
      <input class="my-input" required id="first-name" name="first-name" type="text" />
      <label for="last-name">Last Name</label>
      <input class="my-input" required id="last-name" name="last-name" type="text" />
      <label for="county">County</label>
      <select class="my-input" id="county" name="county">
        <option>Boone</option>
        <option>Campbell</option>
        <option>Kenton</option>
        <option>Grant</option>
      </select>
      <label for="date">Date</label>
      <input class="my-input" required id="date" name="date" type="date" value="<?php echo date('Y-m-d'); ?>" />
    </fieldset>

    <fieldset class="my-fieldset">
      <label for=" file">You may take a picture of the prayer to pre-populate it below.</label>
      <input class="btn btn-secondary my-input" type="file" id="file" name="file">
      <button class="btn btn-secondary my-input" type="button" hx-encoding="multipart/form-data" hx-indicator="#loading" hx-post="/ocr.php" hx-target="#prayer" hx-swap="textContent">
        Convert
        <span class="htmx-indicator" id="loading">⚒ <i>(Working)</i> ⚒</span>
      </button>
      <label for="prayer">Prayer</label>
      <textarea class="my-input" required id="prayer" name="prayer" rows="6"></textarea>
    </fieldset>

    <fieldset class="my-fieldset centered">
      <input value="Publish" type="submit" class="btn btn-primary my-input" />
      <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $success): ?>
        <p id="result">Successfully published <?= $_POST["first-name"] ?>'s prayer!</p>
      <?php endif ?>
      <a href="/index.php" class="btn btn-secondary">Done</a>
    </fieldset>
  </form>
</body>

</html>