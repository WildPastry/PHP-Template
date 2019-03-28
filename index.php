<?php
    /*
        The include and require methods, finds the file you are wanting and places it where you call
        the function.
        The difference between include and require is, with include, if it can't find the file you are
        wanting, it will still continue to render everything bellow it.
        With require, it will stop running, and nothing bellow the call will be rendered.
        So you need to have a think about if what you are wanting to include is important for the site
        or not. If it is, then use require, if not, use include.
    */

    // include("templates/header.php");
    $page = "home";
    $desc = "This is the description of the Home Page";
    require("templates/header.php");
 ?>

<main role="main" class="inner cover">
    <h1 class="cover-heading">Home Page</h1>
    <p class="lead">This is the home page</p>
    <p class="lead">
        <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
    </p>
</main>

<?php require("templates/footer.php"); ?>
