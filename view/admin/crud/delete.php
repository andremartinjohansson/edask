<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

if ($di->get("session")->get("user")["role"] !== "admin") {
    $di->get("response")->redirect("404");
}

// Create urls for navigation
$urlToView = url("admin");



?><h1>Delete a user</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToView ?>">View all</a>
</p>
