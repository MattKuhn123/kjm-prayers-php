<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prayer Board</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/prayer-search.css">
</head>

<body class="centered">
    <form class="my-form" action="/prayer-results.php" id="prayer-search" method="GET">
        <fieldset class="my-fieldset" id="fieldset-query-start">
            <label for="query-start">Would you like to see the latest prayers? Or are you looking for something specific?</label>
            <input class="btn btn-primary btn-fat" type="submit" value="Take me to the latest prayers!" />
            <a href="#fieldset-query-name" class="btn btn-primary btn-fat">I'm looking for something specific.</a>
        </fieldset>

        <fieldset class="my-fieldset" id="fieldset-query-name">
            <label for="query-name">Is there a person you'd like to pray for?</label>
            <input class="my-input" id="query-name" name="query-name" type="search" placeholder="Name" />
            <a href="#fieldset-query-county" class="btn btn-primary btn-fat">Continue</a>
        </fieldset>

        <fieldset class="my-fieldset" id="fieldset-query-county">
            <label for="query-county">Is there a county you'd like to pray for?</label>
            <select class="my-input" id="query-county" name="query-county">
                <option></option>
                <option>Boone</option>
                <option>Campbell</option>
                <option>Kenton</option>
                <option>Grant</option>
            </select>
            <a href="#fieldset-query-date-start" class="btn btn-primary btn-fat">Continue</a>
        </fieldset>

        <fieldset class="my-fieldset" id="fieldset-query-date-start">
            <label for="query-date-start">Are there prayers that were published in a certain time frame that you'd like to pray for?</label>
            <input class="my-input" id="query-date-start" name="query-date-start" type="date" value="<?php echo date('Y-m-d', strtotime('-31 days')); ?>" />
            -
            <input class="my-input" id="query-date-end" name="query-date-end" type="date" value="<?php echo date('Y-m-d'); ?>" />
            <input class="btn btn-primary btn-fat" type="submit" value="Search" />
        </fieldset>

    </form>
</body>

<script type="text/javascript">
    document.location.hash = "#fieldset-query-start";
</script>

</html>