<?php
function is_logged_in_cookies()
{
  if (!isset($_COOKIE["code"]) || !isset($_COOKIE["email"])) {
    return false;
  }

  $code = $_COOKIE["code"];
  $email = $_COOKIE["email"];

  return is_logged_in($code, $email);
}

function is_logged_in_post()
{
  if (!isset($_POST["code"]) || !isset($_POST["email"])) {
    return false;
  }

  $code = $_POST["code"];
  $email = $_POST["email"];

  return is_logged_in($code, $email);
}

function login_post_to_cookies()
{
  $code = $_POST["code"];
  $email = $_POST["email"];

  setcookie("code", $code);
  setcookie("email", $email);
}

function is_logged_in($code, $email)
{
  if (!isset($code) || !isset($email)) {
    return false;
  }

  $db = mysqli_connect();
  try {
    $user_query = "SELECT * FROM `kjm`.`users` WHERE `code` = '$code' AND `email` = '$email' AND `code_expires` >= CURRENT_DATE()";
    $user_query_result = $db->query($user_query);
    if ($user_query_result->num_rows === 0) {
      return false;
    }

    $user = $user_query_result->fetch_row()[0];
    return $user != null;
  } catch (Exception $e) {
  } finally {
    $db->close();
  }
}
