<!DOCTYPE html>
<html lang="en">

<head>
  <title>Prayer Board</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/styles.css">
  <link rel="stylesheet" href="/login-email.css">
</head>

<?php

require './mail-code.php';

$code = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

    $db = mysqli_connect();

    try {
      $email = trim($_POST["email"]);

      $user_query = "SELECT * FROM `kjm`.`users` WHERE `email` = '$email'";
      $user_query_result = $db->query($user_query);

      if ($user_query_result->num_rows === 0) {
        $user_insert = $db->prepare("INSERT INTO `kjm`.`prayers` (`email`) VALUES (?)");
        $user_insert->bind_param("s", $email);
        $user_insert->execute();
        $user_insert->close();
      }

      $code = bin2hex(random_bytes(8));
      $code_expires_time  = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
      $code_expires = date('Y-m-d', $code_expires_time);
      $user_update = $db->prepare("UPDATE `kjm`.`users` SET `code` = ?, `code_expires` = STR_TO_DATE(?, '%Y-%m-%d') WHERE `email` = ?");
      $user_update->bind_param("sss", $code, $code_expires, $email);
      $user_update->execute();
      $user_update->close();

      mail_code($email, $code);
    } catch (Exception $e) {
      echo ("error");
    } finally {
      $db->close();
    }
  }
}
?>

<body>
  <form class="my-form" method="POST" action="login-email.php">
    <fieldset class="my-fieldset">
      <p>Login</p>
    </fieldset>
    <fieldset class="my-fieldset">
      <label for="email">Email</label>
      <input required class="my-input" type="email" name="email" id="email" value="<?= isset($email) ? $email : "" ?>" />
      <input type="submit" value="Login" class="btn btn-primary my-input" />
    </fieldset>
    <?php if (isset($code)): ?>
      <fieldset class="my-fieldset">
        <label for="code">Copy this code:</label>
        <input readonly value="<?= $code ?>" class="my-input" id="code" />
        <a class="btn btn-primary my-input" href="login-code.php">
          Go
        </a>
        <p><i>We are currently working on the ability to email this code to you.</i></p>
      </fieldset>
    <?php endif ?>
  </form>
</body>

</html>