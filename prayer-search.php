<link rel="stylesheet" href="/prayer-search.css">
<form hx-get="/prayer-results.php" id="query-prayer-form">
    <fieldset id="fieldset-query-name">
        <label for="query-name">Do you know the name of the person who's prayers you're looking for?</label>
        <input value="<?= !empty($_GET["query-name"]) ? $_GET["query-name"] : "" ?>" id="query-name" name="query-name" type="search" />
        <a href="#fieldset-query-county" class="btn btn-primary btn-fat">Continue</a>
    </fieldset>

    <fieldset id="fieldset-query-county">
        <label for="query-county">Do you know the county jail of the prayers you're looking for?</label>
        <select id="query-county" name="query-county">
            <option></option>
            <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Boone") echo ("selected"); ?>>Boone</option>
            <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Campbell") echo ("selected"); ?>>Campbell</option>
            <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Kenton") echo ("selected"); ?>>Kenton</option>
            <option <?php if (!empty($_GET["query-county"]) && $_GET["query-county"] === "Grant") echo ("selected"); ?>>Grant</option>
        </select>
        <a href="#fieldset-query-date-start" class="btn btn-primary btn-fat">Continue</a>
    </fieldset>

    <fieldset id="fieldset-query-date-start">
        <label for="query-date-start">Do you around the time the prayer might have been published?</label>
        <input value="<?= !empty($_GET["query-date-start"]) ? $_GET["query-date-start"] : "" ?>" id="query-date-start" name="query-date-start" type="date" />
        <a href="#fieldset-query-date-end" class="btn btn-primary btn-fat">Continue</a>
    </fieldset>

    <fieldset id="fieldset-query-date-end">
        <label for="query-date-end">Do you around the time the prayer might have been published?</label>
        <input value="<?= !empty($_GET["query-date-end"]) ? $_GET["query-date-end"] : "" ?>" id="query-date-end" name="query-date-end" type="date" />
        <input class="btn btn-primary btn-fat" type="submit" />
    </fieldset>
</form>

<script type="text/javascript">
    if (document.location.hash == "" || document.location.hash == "#") {
        document.location.hash = "#fieldset-query-name";
    }

</script>