
<link rel="stylesheet" href="/prayer-search.css">
<form hx-get="/prayer-results.php" id="query-prayer-form">
    <input value="<?= !empty($_GET["query-name"]) ? $_GET["query-name"] : "" ?>" id="query-name" name="query-name" type="search" />
    <select id="query-county" name="query-county" >
        <option></option>
        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Boone") echo ("selected"); ?>>Boone</option>
        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Campbell") echo ("selected"); ?>>Campbell</option>
        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Kenton") echo ("selected"); ?>>Kenton</option>
        <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Grant") echo ("selected"); ?>>Grant</option>
    </select>
    <input value="<?= !empty($_GET["query-date-start"]) ? $_GET["query-date-start"] : "" ?>" id="query-date-start" name="query-date-start" type="date" />
    -
    <input value="<?= !empty($_GET["query-date-end"]) ? $_GET["query-date-end"] : "" ?>" id="query-date-end" name="query-date-end" type="date" />
    <input type="submit" />
</form>