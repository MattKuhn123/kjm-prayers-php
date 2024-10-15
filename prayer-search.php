<form hx-get="/prayer-results.php" id="prayer-search">
    <fieldset id="fieldset-query-start">
        <label for="query-start">Would you like to see the latest prayers? Or are you looking for something specific?</label>
        <input class="btn btn-primary btn-fat" type="submit" value="Take me to the latest prayers!"/>
        <a href="#fieldset-query-name" class="btn btn-primary btn-fat">I'm looking for something specific.</a>
    </fieldset>

    <fieldset id="fieldset-query-name">
        <label for="query-name">Is there a person you'd like to pray for?</label>
        <input value="<?= !empty($_GET["query-name"]) ? $_GET["query-name"] : "" ?>" id="query-name" name="query-name" type="search" />
        <a href="#fieldset-query-county" class="btn btn-primary btn-fat">Continue</a>
    </fieldset>

    <fieldset id="fieldset-query-county">
        <label for="query-county">Is there a county you'd like to pray for?</label>
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
        <label for="query-date-start">Are there prayers that were published in a certain time frame that you'd like to pray for?</label>
        <input value="<?= !empty($_GET["query-date-start"]) ? $_GET["query-date-start"] : "" ?>" id="query-date-start" name="query-date-start" type="date" />
        -
        <input value="<?= !empty($_GET["query-date-end"]) ? $_GET["query-date-end"] : "" ?>" id="query-date-end" name="query-date-end" type="date" />
        <input class="btn btn-primary btn-fat" type="submit" value="Search" />
    </fieldset>
</form>

<script type="text/javascript">
    if (document.location.hash == "" || document.location.hash == "#") {
        document.location.hash = "#fieldset-query-start";
    }
</script>