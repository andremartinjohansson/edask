<div class="thread-content">

    <h2>Questions</h2>

</div>

<?php

$orderBy = isset($_GET["orderby"]) ? $_GET["orderby"] : "time";

$sql = "SELECT * FROM Comments WHERE type = ? ORDER BY $orderBy DESC;";
$questions = $di->get("db")->executeFetchAll($sql, ["question"]);

?>

<div class="comment-section">

    <div class="sort-bar">
        <span><strong>Sort by: </strong></span>
        <a href="<?=$di->get("url")->create('ask') . "?orderby=time"?>" class="sort-link">Latest</a>
        <span> | </span>
        <a href="<?=$di->get("url")->create('ask') . "?orderby=votes"?>" class="sort-link">Most Votes</a>
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

<hr>

<div class="thread-content">

    <h2>Ask</h2>

    <p>Ask us anything about the big universe that is Elite: Dangerous. Someone will
    try to answer as soon as possible!</p>

</div>

<?php if ($di->get("session")->get("user") !== null) : ?>
    <div class="leave-comment">
        <form action="<?=$di->get("url")->create('post_comment')?>" method="post">
            <div class="compose-comment">
                <p class="p-tags">Topic</p>
                <input class="input-tags" type="text" name="topic" placeholder="Topic of your question" required>
                <p class="p-tags">Your question</p>
                <textarea class="comment-text" name="comment" required="required" placeholder="Formulate your question..."></textarea>
                <p class="p-tags">Enter tags (seperated by a comma ,)</p>
                <input class="input-tags" type="text" name="tags" placeholder="Tags" required>
            </div>
            <input class="comment-post" name="submit" type="submit" value="Ask!">
        </form>
    </div>
<?php endif; ?>
