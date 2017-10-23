<?php

if (isset($_GET["name"])) {
    $name = $_GET["name"];
} else {
    die();
}

?>

<div class="thread-content">

    <h2>#<?=$name?></h2>

    <p>All questions with the tag #<?=$name?>.</p>

</div>

<?php

$orderBy = isset($_GET["orderby"]) ? $_GET["orderby"] : "time";

$sql = "SELECT * FROM Comments WHERE tags LIKE ? ORDER BY $orderBy DESC;";
$questions = $di->get("db")->executeFetchAll($sql, ["%" . $name . "%"]);

?>

<div class="comment-section">

    <div class="sort-bar">
        <span><strong>Sort by: </strong></span>
        <a href="<?=$di->get("request")->getRoute() . "?name={$name}&orderby=time"?>" class="sort-link">Latest</a>
        <span> | </span>
        <a href="<?=$di->get("request")->getRoute() . "?name={$name}&orderby=votes"?>" class="sort-link">Most Votes</a>
    </div>

    <?php foreach ($questions as $question) : ?>
        <div class="comment-list-item">
            <div class="comment-details">
                <span class="comment-votes"><?=$question->votes?><br>votes</span>
                <span class="comment-answers"><?=$question->answers?><br>answers</span>
            </div>
            <div class="comment-main">
                <a href="<?=$di->get("url")->create('question') . "?id=" . $question->id?>" class="comment-title"><?=$question->topic?></a>
                <div class="comment-tags">
                    <?php $tags = explode(",", $question->tags); ?>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?=$di->get("url")->create('tag') . "?name=" . $tag?>" class="comment-tag">#<?=$tag?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="comment-user-details">
                <span class="user-link"><a href="<?=$di->get("url")->create('member') . "?name=" . $question->author?>"><?=$question->author?></a> / </span>
                <span class="comment-time"><?=$question->time?></span>
            </div>
        </div>
    <?php endforeach; ?>

</div>
