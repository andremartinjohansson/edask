<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

if ($di->get("session")->get("user")["role"] !== "admin") {
    $di->get("response")->redirect("404");
}

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("admin/create");
$urlToDelete = url("admin/delete");



?><h1>View all users</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create</a> |
    <a href="<?= $urlToDelete ?>">Delete</a>
</p>

<?php if (!$items) : ?>
    <p>There are no users.</p>
<?php
    return;
endif;
?>

<table>
    <tr>
        <th>Id</th>
        <th>Acronym</th>
        <th>Email</th>
        <th>Role</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("admin/update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><?= $item->acronym ?></td>
        <td><?= $item->email ?></td>
        <td><?= $item->role ?></td>
    </tr>
    <?php endforeach; ?>
</table>
