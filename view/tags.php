<?php

$sql = "SELECT DISTINCT tags FROM Comments;";
$used = $di->get("db")->executeFetchAll($sql);

$tags = array();
$allTags = array();

foreach ($used as $comment) {
    if ($comment->tags !== null) {
        $tagsArray = explode(",", $comment->tags);
        foreach ($tagsArray as $theTag) {
            array_push($allTags, $theTag);
        }
    }
}

$values = array_count_values($allTags);
arsort($values);
$tags = array_keys($values);

?>

<div class="thread-content">
    <h2>Tags</h2>

    <p>This is a list of all used tags.</p>
</div>

<div class="tags">
    <?php foreach ($tags as $name) : ?>
        <div class="tags-wrap">
            <a href="<?=$di->get("url")->create('tag') . "?name=" . $name?>" class="tags-link">#<?=$name?></a>
        </div>
    <?php endforeach; ?>
</div>
