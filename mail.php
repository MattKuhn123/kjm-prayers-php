<?php


if (!isset($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "invalid email";
    return;
}

echo "TODO";

?>