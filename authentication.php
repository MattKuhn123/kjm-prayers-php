<?php
function is_logged_in() 
{
    if (!isset($_COOKIE["code"]) || !isset($_COOKIE["email"])) {
        return false;
    }

    $code = $_COOKIE["code"];
    $email = $_COOKIE["email"];

    return login($code, $email);
}

function login($code, $email)
{
    if (!isset($code) || !isset($email)) {
        return false;
    }

    $db = mysqli_connect();
    try {
        $user_query = "SELECT * FROM `kjm`.`users` WHERE `code` = '$code' AND `email` = '$email' AND `code_expires` >= CURRENT_DATE()";
        $user_query_result = $db->query($user_query);
        if ($user_query_result == null || $user_query_result->num_rows == 0) {
            return false;
        }

        $user = $user_query_result->fetch_row()[0];
        return $user != null;
    } catch (Exception $e) {
    } finally {
        $db->close();
    }
}
