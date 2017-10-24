<div class="thread-content">

    <h2>Latest Questions</h2>

</div>

<?php

$orderBy = "time";

$sql = "SELECT * FROM Comments WHERE type = ? ORDER BY $orderBy DESC LIMIT 10;";
$questions = $di->get("db")->executeFetchAll($sql, ["question"]);

?>

<div class="comment-section">

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
$popular = array_slice($tags, 0, 11, true);

?>

<div class="thread-content">

    <h2>Popular Tags</h2>

</div>

<div class="tags">
    <?php foreach ($popular as $name) : ?>
        <div class="tags-wrap">
            <a href="<?=$di->get("url")->create('tag') . "?name=" . $name?>" class="tags-link">#<?=$name?></a>
        </div>
    <?php endforeach; ?>
</div>

<?php

$sql = "SELECT * FROM Rep ORDER BY rep DESC LIMIT 5;";
$members = $di->get("db")->executeFetchAll($sql);



?>

<div class="thread-content">

    <h2>Most Active Users</h2>

</div>

<div class="roster">
    <?php foreach ($members as $member) : ?>
        <div class="member-wrap">
            <a href="<?=$di->get("url")->create('member') . "?name=" . $member->user?>" class="member-link"><?=$member->user?></a>
        </div>
    <?php endforeach; ?>
</div>
