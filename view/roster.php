<?php

$sql = "SELECT DISTINCT author FROM Comments;";
$members = $di->get("db")->executeFetchAll($sql);

?>

<div class="thread-content">
    <h2>Roster</h2>

    <p>This is a list of everyone who has interacted in the community.</p>
</div>

<div class="roster">
    <?php foreach ($members as $member) : ?>
        <div class="member-wrap">
            <a href="<?=$di->get("url")->create('member') . "?name=" . $member->author?>" class="member-link"><?=$member->author?></a>
        </div>
    <?php endforeach; ?>
</div>
